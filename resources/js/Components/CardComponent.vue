<script setup>
const props = defineProps({
  data: {
    type: Object,
    required: true
  }
})

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

const getBackgroundImageUrl = (weatherCode) => {
  switch (weatherCode) {
    case '0':
      return 'url(https://img.freepik.com/premium-photo/yellow-sun-3d-illustration_574171-10.jpg?w=826)';
    case '1':
      return 'url(https://img.freepik.com/premium-photo/gloomy-3d-weather-icon-3d-climate-icon-3d-element_118019-7191.jpg?w=826)';
    case '3':
      return 'url(https://img.freepik.com/premium-photo/rain-cloud-with-water-drops-white-cloud-with-rain-drops-sun-it-weather-icon_554821-1902.jpg?w=826)';
    case '30':
      return 'url(https://img.freepik.com/free-photo/weather-icon-with-rain-cloud-with-water-drops_107791-17374.jpg?t=st=1717850917~exp=1717854517~hmac=f4d963ec29b8b832dc19e2d298fcea0e6acb4546a9f3c6e8074c35dff03fbfc9&w=826)';
    case '60':
      return 'url(https://img.freepik.com/premium-photo/3d-thundery-rain-illustration_541443-3240.jpg?w=826)';
    default:
      return 'url()';
  }
};

</script>
<template>
  <div>
    <div
      :style="{ backgroundImage: getBackgroundImageUrl(props.data.weather), backgroundSize: 'cover' }"
      class="bg-gray-300 backdrop-filter backdrop-blur-sm bg-opacity-50 rounded-lg p-2 shadow-lg"
    >
      <div class="font-bold">
        {{ formattedDate(props.data.datetime) }}
      </div>
      <div class="flex gap-2 flex-wrap h-[70px]">
        <p class="font-bold">Humidity: {{ props.data.hu }}%</p>
      </div>
      <p class="bg-gray-400 bg-opacity-80 rounded-lg font-bold text-white p-2 shadow-lg">Temperature : {{ props.data.t[0] + ' &deg;C' + ' ' + props.data.t[1] + ' &deg;F' }}</p>
    </div>
  </div>
</template>