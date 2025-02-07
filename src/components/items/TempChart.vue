<template>
  <div class="chart-container">
    <!-- <h2>全球氣溫</h2> -->
    <div v-if="isLoading">正在加載數據...</div>
    <canvas ref="TemperatureChart" v-if="!isLoading && !error"></canvas>
  </div>
</template>


<script setup>
import { ref, onMounted } from "vue";
import { Chart } from "chart.js/auto";

const TemperatureChart = ref(null);
const chartInstance = ref(null); // Chart.js 實例
const isLoading = ref(true);
const error = ref(null);

// 儲存動態半徑的數值，讓定時器更新
let dynamicRadius = 6;

const fetchTempData = async () => {
  try {
    const response = await fetch(`${import.meta.env.BASE_URL}globalData/Temperature.txt`);
    if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

    const text = await response.text();
    const lines = text.split("\n").filter(line => !line.startsWith("#") && line.trim() !== "");

    const labels = [];
    const yearlyTemps  = [];
    const movingAvgTemps = [];

    lines.forEach(line => {
      const parts = line.trim().split(/\s+/);
      if (parts.length >= 3) {
        const year = parseInt(parts[0]); // 年份
        const yearlyTemp  = parseFloat(parts[1]); // 年均溫度
        const movingAvgTemp = parseFloat(parts[2]); // 5 年移動平均溫度

        if (!isNaN(year) && !isNaN(yearlyTemp) && !isNaN(movingAvgTemp)) {
          labels.push(year);
          yearlyTemps.push(yearlyTemp);
          movingAvgTemps.push(movingAvgTemp);
        }
      }
    });

    // const sortedData = labels.map((year, index) => ({ year, yearlyTemp : yearlyTemps [index] }))
    //   .sort((a, b) => a.year - b.year); // 按年份排序

    // const sortedLabels = sortedData.map(d => d.year); // 年份
    // const sortedValues = sortedData.map(d => d.yearlyTemp ); // 年均溫度

    isLoading.value = false;
    setTimeout(() => createChart(labels, yearlyTemps, movingAvgTemps), 100);
  } catch (err) {
    error.value = err.message;
    isLoading.value = false;
  }
};


const createChart = (labels, yearlyTemps, movingAvgTemps) => {
  if (!TemperatureChart.value) {
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
    const dataset = chart.data.datasets[0]; // ✅ 5 年移動平均
    const meta = chart.getDatasetMeta(0); // ✅ 5 年移動平均的 meta 數據

    // **✅ 如果 5 年移動平均圖層被隱藏，就不畫紅點**
    if (dataset.hidden || meta.hidden || meta.data.length === 0) return;

    const latestPoint = meta.data[meta.data.length - 1]; // ✅ 取得最新的資料點
    if (!latestPoint || !latestPoint.hasValue()) return;

    const { x, y } = latestPoint.getProps(["x", "y"]); // ✅ 確保 x, y 座標正確

    // **繪製閃爍紅點**
    const radius = Math.abs(Math.sin(Date.now() / 500)) * 6 + 6; // ✅ 閃爍半徑

    ctx.save();
    ctx.beginPath();
    ctx.arc(x, y, radius, 0, Math.PI * 2);
    ctx.fillStyle = "rgba(160, 40, 40, .8)"; // ✅ 紅色閃爍
    ctx.fill();
    ctx.closePath();
    ctx.restore();
  },
};

  const customLegendColorPlugin = {
    id: "customLegendColor",
    afterUpdate(chart) {
      const legend = chart.legend;
      if (!legend) return;

      legend.legendItems.forEach((item) => {
        if (item.text === "年均溫") {
          item.fillStyle = "#d0ad44"; // ✅ 修改年均溫的圖例顏色
        } else if (item.text === "移動平均線(5年)") {
          item.fillStyle = "#fffff0"; // ✅ 修改 5 年移動平均的圖例顏色
        }
      });
    }
  };


  chartInstance.value = new Chart(TemperatureChart.value, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
      {
        label: "移動平均線(5年)", // ✅ 新增的數據
        data: movingAvgTemps,
        borderColor: "rgba(255, 255, 240, .8)", // ✅ 白色線條
        borderWidth: 2,
        showLine: true,
        spanGaps: true,
        borderJoinStyle: "bevel",
        tension: 1,
        fill: false,
        pointRadius: 0, // ✅ 不顯示數據點
        pointStyle: "circle", // ✅ 數據點樣式設為線
        pointBorderColor: "transparent", // ✅ 移除圓形圖例的外框
        pointHoverBackgroundColor: "rgba(208, 173, 68, .8)", // 滑鼠懸停時點的背景顏色
        pointHoverBorderColor: "rgba(84, 84, 84, .8)", // 滑鼠懸停時點的邊框顏色
        pointHoverRadius: 8, // 滑鼠懸停時點的半徑
        pointHoverBorderWidth: .5, // 滑鼠懸停時點的邊框寬度
        // hitRadius: 300, // ✅ 擴大 hover 作用範圍
        pointHitRadius: 300, // 點的擊中半徑
      },

      {
        label: "年均溫", // 標籤
        data: yearlyTemps, // 數據
        borderColor: "rgba(208, 173, 68, .8)", // 線條顏色
        borderWidth: 2, // 線條寬度
        showLine: true, // 顯示線條
        spanGaps: true, // ✅ 確保數據之間不會有間斷
        borderJoinStyle: "bevel", // 線條連接樣式
        // hoverBorderColor: "rgba(100, 100, 100, 1)", // 滑鼠懸停時線條的顏色。
        tension: 1, // 曲線張力
        fill: false, // 填充區域
        // backgroundColor: "rgba(84, 84, 84, .5)", // 填充區域的背景顏色
        borderCapStyle: "round", // 線條端點樣式
        // borderDash: [5, 5], // 虛線
        // hoverBackgroundColor: "rgba(255, 255, 255, 1)", // 滑鼠懸停時的背景顏色
        pointBackgroundColor: "rgba(208, 173, 68, 1)", // 點的背景顏色
        pointBorderColor:'#545454',
        pointBorderWidth: .5, // 點的邊框寬度
        pointRadius: 3, // 點的半徑
        pointHitRadius: 300, // 點的擊中半徑
        pointStyle: "circle", // 點的樣式
        pointHoverBackgroundColor: "rgba(208, 173, 68, .8)", // 滑鼠懸停時點的背景顏色
        pointHoverBorderColor: "rgba(84, 84, 84, .8)", // 滑鼠懸停時點的邊框顏色
        pointHoverRadius: 8, // 滑鼠懸停時點的半徑
        pointHoverBorderWidth: .5, // 滑鼠懸停時點的邊框寬度

      },

      ]
    },
    options: {
      responsive: true,
      interaction: {
          mode: "index",
          axis: "xy",
          intersect: false, // ✅ 讓 tooltip 在 X 軸對應的所有數據都顯示
          },
      maintainAspectRatio: true, // 允許自訂高度
      plugins: {
        legend: {
          position: "bottom",
          align: "start",
          display: true,
          labels: { usePointStyle: true, boxWidth: 8, boxHeight: 8, color: "#fffff0", font: { size: 14, weight: "bold" }}
        },
        title: {
          position: "top",
          align: "center",
          display: true, text: "全球溫度變化", color: '#fffff0', font: { size: 18, weight: 'bold', family: 'DM Sans, Noto Sans' } },
        tooltip: {
          enabled: true,
          mode: "index", // ✅ 讓 tooltip 同時顯示所有數據集的值
          intersect: false, // ✅ 讓 tooltip 在軸上顯示（而不是只在點上）
          callbacks: {
            label: function (context) {
              let label = context.dataset.label || "";
              if (context.raw !== null) {
                label += `: ${context.raw.toFixed(2)} °C`; // ✅ 顯示溫度數值，保留 2 位小數
              }
              return label;
            },
          },
        },
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
          title: { display: true, text: "年均溫變化 (℃)", color: '#fffff0', font: { size: 18, weight: 'bold', family: 'DM Sans, Noto Sans' } },
          grid: { color: "rgba(84, 84, 84, .8)", lineWidth: .4 },
        },
      }
    },

    plugins: [highlightLastPointPlugin, customLegendColorPlugin ],

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
  fetchTempData();
});

</script>
