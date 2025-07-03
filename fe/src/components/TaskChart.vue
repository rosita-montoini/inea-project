<template>
  <div>
    <canvas ref="chartRef"></canvas>
  </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import {
  Chart,
  BarElement,
  BarController,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend,
} from "chart.js";

Chart.register(
  BarElement,
  BarController,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
);

const props = defineProps({
  tasks: Array,
  projectId: [Number, null],
});

const chartRef = ref(null);
let chartInstance = null;

const createChart = () => {
  const filteredTasks = props.tasks.filter(
    (task) => task.project_id === props.projectId
  );

  const statusCounts = {
    open: 0,
    in_progress: 0,
    done: 0,
  };

  filteredTasks.forEach((task) => {
    if (statusCounts[task.status] !== undefined) {
      statusCounts[task.status]++;
    }
  });

  const data = {
    labels: ["Open", "In Progress", "Done"],
    datasets: [
      {
        label: "Tasks by Status",
        data: [statusCounts.open, statusCounts.in_progress, statusCounts.done],
        backgroundColor: ["#0099ff", "#ff791f", "#4dc000"],
      },
    ],
  };

  const config = {
    type: "bar",
    data,
    options: {
      responsive: true,
      plugins: {
        legend: { display: true },
      },
    },
  };

  if (chartInstance) {
    chartInstance.destroy();
  }

  chartInstance = new Chart(chartRef.value, config);
};

onMounted(() => {
  createChart();
});

watch(() => props.tasks, createChart, { deep: true });
watch(() => props.projectId, createChart);
</script>
