<template>
  <div class="chart-container">
    <!-- <h2>南極洲冰層</h2> -->
    <div v-if="isLoading">正在加載數據...</div>
    <canvas ref="IceChart" v-if="!isLoading && !error"></canvas>
  </div>
</template>


<script setup>
import { ref, onMounted } from "vue";
import { Chart } from "chart.js/auto";

const IceChart = ref(null);
const chartInstance = ref(null); // Chart.js 實例
const isLoading = ref(true);
const error = ref(null);

// 儲存動態半徑的數值，讓定時器更新
let dynamicRadius = 6;

const fetchIceData = async () => {
  try {
    const response = await fetch(`${import.meta.env.BASE_URL}globalData/Ice_Sheets_200204_202408.txt`);
    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

    const text = await response.text();
    const lines = text.split("\n").filter(line => !line.startsWith("#") && line.trim() !== "");

    const labels = [];
    const values = [];

    lines.forEach(line => {
      const parts = line.trim().split(/\s+/);
      if (parts.length >= 2) {
        const year = parseInt(parts[0]);
        const ice = parseFloat(parts[1]);
        if (!isNaN(year) && !isNaN(ice)) {
          labels.push(year);
          values.push(ice);
        }
      }
    });

    const sortedData = labels.map((year, index) => ({ year, ice: values[index] }))
      .sort((a, b) => a.year - b.year);

    const sortedLabels = sortedData.map(d => d.year);
    const sortedValues = sortedData.map(d => d.ice);

    isLoading.value = false;
    setTimeout(() => createChart(sortedLabels, sortedValues), 100);
  } catch (err) {
    error.value = err.message;
    isLoading.value = false;
  }
};

const createChart = (labels, data) => {
  if (!IceChart.value) {
    console.error("❌ Chart canvas not found!");
    return;
  }

  if (chartInstance.value) {
    chartInstance.value.destroy();
  }

  // 插件：持續閃爍的提示點
  const highlightLastPointPlugin = {
    id: "highlightLastPoint",
    afterDatasetsDraw(chart) {
      const ctx = chart.ctx;
      const dataset = chart.data.datasets[0];
      const meta = chart.getDatasetMeta(0);
      const latestPoint = meta.data[meta.data.length - 1]; // 最新資料點

      if (!latestPoint) return;

      const x = latestPoint.x; // 最新資料點的 X 座標
      const y = latestPoint.y; // 最新資料點的 Y 座標

      // 繪製閃爍的圓點
      ctx.save();
      ctx.beginPath();
      ctx.arc(x, y, dynamicRadius, 0, Math.PI * 2);
      ctx.fillStyle = "rgba(160, 40, 40, .8)";
      ctx.fill();
      ctx.closePath();
      ctx.restore();
    },
  };

  chartInstance.value = new Chart(IceChart.value, {
    type: "line",
    data: {
      labels: labels,
      datasets: [{
        label: "質量", // 標籤
        data: data, // 數據
        borderColor: "rgba(250, 250, 240, .8)", // 線條顏色
        borderWidth: 2, // 線條寬度
        showLine: true, // 顯示線條
        spanGaps: false, // ✅ 確保數據之間不會有間斷
        borderJoinStyle: "bevel", // 線條連接樣式
        // hoverBorderColor: "rgba(100, 100, 100, 1)", // 滑鼠懸停時線條的顏色。
        tension: 1, // 曲線張力
        fill: false, // 填充區域
        // backgroundColor: "rgba(255, 255, 240, .2)", // 填充區域的背景顏色
        borderCapStyle: "round", // 線條端點樣式
        // borderDash: [5, 5], // 虛線
        // hoverBackgroundColor: "rgba(255, 255, 255, 1)", // 滑鼠懸停時的背景顏色
        pointBackgroundColor: "rgba(255, 255, 249, 1)", // 點的背景顏色
        pointBorderWidth: 0, // 點的邊框寬度
        pointRadius: 0, // 點的半徑
        pointHitRadius: 300, // 點的擊中半徑
        pointStyle: "circle", // 點的樣式
        pointHoverBackgroundColor: "rgba(208, 173, 68, .8)", // 滑鼠懸停時點的背景顏色
        pointHoverBorderColor: "rgba(84, 84, 84, .8)", // 滑鼠懸停時點的邊框顏色
        pointHoverRadius: 8, // 滑鼠懸停時點的半徑
        pointHoverBorderWidth: .5, // 滑鼠懸停時點的邊框寬度
        pointHoverRadius: 8, // 滑鼠懸停時點的半徑
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true, // 允許自訂高度
      plugins: {
        legend: {
          position: "right",
          align: "start",
          display: false,
          labels: { color: "#fffff0", font: { size: 14, weight: "bold" }}
        },
        title: {
          position: "top",
          align: "center",
          display: true, text: "南極洲冰層變化", color: '#fffff0', font: { size: 18, weight: 'bold', family: 'DM Sans, Noto Sans' } },
        tooltip: { enabled: true },

      },
      hover: {
        mode: "nearest",
        intersect: true,
      },
      layout: {
        padding: {
          right: 12,  // ✅ 增加右邊距
          left: 12,  // ✅ 增加右邊距
        },
      },
      scales: {
        x: {
          ticks: { font: { size: 12, weight: 'bold', family: 'DM Sans, Noto Sans' }, color: '#fffff0' },
          title: { display: true, text: "年份", color: '#fffff0', font: { size: 18, weight: 'bold', family: 'DM Sans, Noto Sans' } },
          grid: { color: "rgba(84, 84, 84, .8)", lineWidth: .4 },
         },
        y: {
          ticks: { font: { size: 12, weight: 'bold', family: 'DM Sans, Noto Sans' }, color: '#fffff0' },
          title: { display: true, text: "質量 (Gt)", color: '#fffff0', font: { size: 18, weight: 'bold', family: 'DM Sans, Noto Sans' } },
          grid: { color: "rgba(84, 84, 84, .8)", lineWidth: .4 },
        },
      }
    },

    plugins: [highlightLastPointPlugin],

  });
  // 啟動閃爍動畫的定時器
  startBlinking();
};
const startBlinking = () => {
  setInterval(() => {
    // 動態更新半徑大小
    dynamicRadius = Math.abs(Math.sin(Date.now() / 1000)) * 6 + 6;

    // 重新繪製圖表（不觸發重計算）
    if (chartInstance.value) {
      chartInstance.value.draw(); // 只繪製圖表，不更新數據或狀態
    }
  }, 50); // 每 50ms 更新一次
};

onMounted(() => {
  fetchIceData();
});

</script>
