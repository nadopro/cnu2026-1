<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N-gram 네트워크 다이어그램</title>
    <script src="https://cdn.jsdelivr.net/npm/d3@7/dist/d3.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: "Malgun Gothic", "Noto Sans KR", Arial, sans-serif;
            background: #f7f8fa;
            color: #212529;
        }
        header {
            padding: 16px 22px;
            background: #1f2937;
            color: #fff;
        }
        header h2 {
            margin: 0 0 6px 0;
            font-size: 22px;
        }
        header p {
            margin: 0;
            font-size: 14px;
            color: #d1d5db;
        }
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            padding: 12px 22px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }
        .toolbar label {
            font-size: 14px;
        }
        .toolbar input {
            width: 72px;
            padding: 5px 7px;
        }
        .toolbar button {
            padding: 7px 12px;
            border: 1px solid #0d6efd;
            background: #0d6efd;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }
        .toolbar button.secondary {
            border-color: #6c757d;
            background: #6c757d;
        }
        #chart {
            width: 100vw;
            height: calc(100vh - 132px);
            background: #ffffff;
        }
        .link {
            stroke: #6b7280;
            stroke-opacity: 0.42;
        }
        .node text {
            pointer-events: none;
            font-weight: 700;
            fill: #111827;
            paint-order: stroke;
            stroke: white;
            stroke-width: 3px;
            stroke-linejoin: round;
        }
        .legend {
            position: absolute;
            right: 16px;
            top: 112px;
            background: rgba(255,255,255,0.92);
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 13px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }
        .legend div {
            margin: 4px 0;
        }
        .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 6px;
            vertical-align: -1px;
        }
        .msg {
            padding: 24px;
            color: #b91c1c;
        }
    </style>
</head>
<body>
<header>
    <h2>N-gram 네트워크 다이어그램</h2>
    <p>1음절 → 2음절, 2음절 → 3음절 연결 관계를 시각화합니다. 노드 색 농도와 링크 두께는 빈도에 비례합니다.</p>
</header>

<div class="toolbar">
    <label>최소 빈도 <input type="number" id="minFreq" value="1" min="1"></label>
    <label>전하 강도 <input type="number" id="charge" value="-260" step="20"></label>
    <label>링크 거리 <input type="number" id="distance" value="95" step="5"></label>
    <button type="button" id="applyBtn">다시 그리기</button>
    <button type="button" id="fitBtn" class="secondary">가운데 맞춤</button>
</div>

<div class="legend">
    <div><span class="dot" style="background:#deebf7"></span>1음절</div>
    <div><span class="dot" style="background:#9ecae1"></span>2음절</div>
    <div><span class="dot" style="background:#3182bd"></span>3음절</div>
    <div>짙은 색 = 높은 빈도</div>
    <div>두꺼운 선 = 강한 연결</div>
</div>

<svg id="chart"></svg>

<script>
let rawData = null;
let svg, g, simulation, zoom;

function nodeBaseColor(gram) {
    if (gram === 1) return '#deebf7';
    if (gram === 2) return '#9ecae1';
    return '#3182bd';
}

function darkerColorByFrequency(baseColor, freq, maxFreq) {
    const c = d3.color(baseColor);
    const ratio = maxFreq > 0 ? freq / maxFreq : 0;
    return d3.rgb(c).darker(ratio * 2.2).formatHex();
}

function buildChart(data) {
    const minFreq = Math.max(1, parseInt(document.getElementById('minFreq').value || '1', 10));
    const charge = parseInt(document.getElementById('charge').value || '-260', 10);
    const distance = parseInt(document.getElementById('distance').value || '95', 10);

    const width = window.innerWidth;
    const height = window.innerHeight - 132;

    svg = d3.select('#chart')
        .attr('width', width)
        .attr('height', height);

    svg.selectAll('*').remove();

    zoom = d3.zoom()
        .scaleExtent([0.2, 5])
        .on('zoom', (event) => g.attr('transform', event.transform));

    svg.call(zoom);
    g = svg.append('g');

    const nodes = data.nodes
        .filter(d => d.frequency >= minFreq)
        .map(d => ({ ...d }));

    const nodeIds = new Set(nodes.map(d => d.id));
    const links = data.links
        .filter(d => nodeIds.has(d.source) && nodeIds.has(d.target))
        .map(d => ({ ...d }));

    if (nodes.length === 0) {
        d3.select('body').append('div').attr('class', 'msg').text('표시할 노드가 없습니다. 최소 빈도를 낮춰주세요.');
        return;
    }

    const maxFreq = d3.max(nodes, d => d.frequency) || 1;
    const maxLink = d3.max(links, d => d.value) || 1;

    const radius = d3.scaleSqrt()
        .domain([1, maxFreq])
        .range([8, 34]);

    const linkWidth = d3.scaleLinear()
        .domain([1, maxLink])
        .range([1, 9]);

    const link = g.append('g')
        .selectAll('line')
        .data(links)
        .enter()
        .append('line')
        .attr('class', 'link')
        .attr('stroke-width', d => linkWidth(d.value));

    const node = g.append('g')
        .selectAll('g')
        .data(nodes)
        .enter()
        .append('g')
        .attr('class', 'node')
        .call(d3.drag()
            .on('start', dragstarted)
            .on('drag', dragged)
            .on('end', dragended));

    node.append('circle')
        .attr('r', d => radius(d.frequency))
        .attr('fill', d => darkerColorByFrequency(nodeBaseColor(d.gram), d.frequency, maxFreq))
        .attr('stroke', '#1f2937')
        .attr('stroke-width', 0.8)
        .append('title')
        .text(d => `${d.label}\n${d.gram}음절\n빈도: ${d.frequency}`);

    node.append('text')
        .attr('x', d => radius(d.frequency) + 5)
        .attr('y', 4)
        .attr('font-size', d => Math.max(12, Math.min(24, radius(d.frequency))))
        .text(d => d.label);

    simulation = d3.forceSimulation(nodes)
        .force('link', d3.forceLink(links).id(d => d.id).distance(distance).strength(0.75))
        .force('charge', d3.forceManyBody().strength(charge))
        .force('center', d3.forceCenter(width / 2, height / 2))
        .force('collision', d3.forceCollide().radius(d => radius(d.frequency) + 20))
        .on('tick', ticked);

    function ticked() {
        link
            .attr('x1', d => d.source.x)
            .attr('y1', d => d.source.y)
            .attr('x2', d => d.target.x)
            .attr('y2', d => d.target.y);

        node.attr('transform', d => `translate(${d.x},${d.y})`);
    }

    function dragstarted(event, d) {
        if (!event.active) simulation.alphaTarget(0.3).restart();
        d.fx = d.x;
        d.fy = d.y;
    }

    function dragged(event, d) {
        d.fx = event.x;
        d.fy = event.y;
    }

    function dragended(event, d) {
        if (!event.active) simulation.alphaTarget(0);
        d.fx = null;
        d.fy = null;
    }
}

function fitCenter() {
    if (!svg || !g || !zoom) return;
    svg.transition().duration(400).call(zoom.transform, d3.zoomIdentity);
}

fetch('data.json?ts=' + Date.now())
    .then(response => {
        if (!response.ok) {
            throw new Error('data.json을 불러오지 못했습니다.');
        }
        return response.json();
    })
    .then(data => {
        rawData = data;
        buildChart(rawData);
    })
    .catch(error => {
        document.body.innerHTML += '<div class="msg">' + error.message + '<br>먼저 ngram2.php에서 분석을 실행해 data.json을 생성하세요.</div>';
    });

document.getElementById('applyBtn').addEventListener('click', function () {
    if (rawData) buildChart(rawData);
});

document.getElementById('fitBtn').addEventListener('click', fitCenter);

window.addEventListener('resize', function () {
    if (rawData) buildChart(rawData);
});
</script>
</body>
</html>
