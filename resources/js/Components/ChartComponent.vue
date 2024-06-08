<script setup>
import { ref, onMounted, watch } from 'vue';
import Chart from 'chart.js/auto';

const props = defineProps({
  weatherData: {
    type: Array,
    required: true,
    default: () => []
  }
});

const weatherChart = ref(null);
let chartInstance = null;

const formattedDate = (val) => {
  const year = val.substring(0, 4);
  const month = val.substring(4, 6) - 1;
  const day = val.substring(6, 8);
  const hour = val.substring(8, 10);
  const minute = val.substring(10, 12);

  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
  const monthName = months[month];

  const date = new Date(year, month, day, hour, minute);

  const formattedDate = `${monthName}, ${parseInt(day, 10)} ${year}, ${('0' + date.getHours()).slice(-2)}:${('0' + date.getMinutes()).slice(-2)}`;

  return formattedDate;
};

const renderChart = (data) => {
  const ctx = weatherChart.value.getContext('2d');
  const labels = data.map(item => formattedDate(item.datetime));
  const temperatures = data.map(item => parseFloat(item.t[0]));
  const humidity = data.map(item => parseFloat(item.hu));

  if (chartInstance) {
    chartInstance.destroy();
  }

  chartInstance = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Temperature (°C)',
          data: temperatures,
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor: 'rgba(255, 99, 132, 1)',
          borderWidth: 1,
          yAxisID: 'y-axis-1'
        },
        {
          label: 'Humidity (%)',
          data: humidity,
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
          yAxisID: 'y-axis-2'
        }
      ]
    },
    options: {
      scales: {
        'y-axis-1': {
          type: 'linear',
          display: true,
          position: 'left',
        },
        'y-axis-2': {
          type: 'linear',
          display: true,
          position: 'right',
          grid: {
            drawOnChartArea: false
          }
        }
      }
    }
  });
};

onMounted(() => {
  renderChart(props.weatherData);
});

watch(() => props.weatherData, (newData) => {
  renderChart(newData);
});
</script>

<template>
  <div class="w-[1000px]">
    <canvas ref="weatherChart"></canvas>
  </div>
</template>
