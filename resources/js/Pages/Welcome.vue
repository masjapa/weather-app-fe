<script setup>
import { Head } from '@inertiajs/vue3';
import { toRaw, computed, ref, watch } from 'vue'
import ChartComponent from '../Components/ChartComponent.vue'
import CardComponent from '../Components/CardComponent.vue'
import Navbar from '../Components/Navbar.vue'
import Footer from '../Components/Footer.vue'
import RegionSelector from '../Components/RegionSelector.vue'

const props = defineProps({
  data: {
    type: Array,
    required: true,
    default: () => [],
  },
});

let parameter = ref([])
const rawData = toRaw(props.data)
const selectedRegion = ref('Bandung')
const regionList = ref(rawData.map((x) => x.name[0]))
const filteredData = computed(() => rawData.filter((x) => x.name[0] === selectedRegion.value))

if (Array.isArray(filteredData.value) && filteredData.value.length > 0) { 
  filteredData.value.forEach(test => {
    parameter = test.parameter
  });
} else {
  console.warn('no data')
}

const groupByDatetime = (data) => {
  const groupedData = {};
  
  data.forEach(item => {
    item.timerange.forEach(entry => {
      const datetime = entry["@attributes"]["datetime"];
      
      if (!groupedData[datetime]) {
        groupedData[datetime] = {};
      }
      
      const attributeId = item["@attributes"]["id"];
      const value = entry.value;
      groupedData[datetime][attributeId] = value;
    });
  });
  
  Object.keys(groupedData).forEach(datetime => {
    data.forEach(item => {
      const attributeId = item["@attributes"]["id"];
      if (!groupedData[datetime][attributeId]) {
        groupedData[datetime][attributeId] = null;
      }
    });
  });
  
  return groupedData;
};


const groupedData = groupByDatetime(parameter);

let dataArray = Object.entries(groupedData).map(([datetime, attributes]) => {
  return {
    datetime,
    ...attributes
  };
});

const handleRegionChange = (region) => {
  selectedRegion.value = region;
  let newArr = rawData.filter((x) => x.name[0] === selectedRegion.value)
  let param = {}
  if (Array.isArray(newArr) && newArr.length > 0) { 
    newArr.forEach(x => {
      param = x.parameter
    });
  } else {
    console.warn('no data')
  }
    let newGroup = groupByDatetime(param)

    dataArray = Object.entries(newGroup).map(([datetime, attributes]) => {
    return {
      datetime,
      ...attributes
    };
  });
};
</script>

<template>
  <Head title="Welcome" />
  <div>
    <Navbar />
    <div class="flex justify-center gap-4 rounded-lg p-6 flex-col">
      <div class="flex justify-end">
        <RegionSelector 
            :regionList="regionList" 
            :selectedRegion="selectedRegion" 
            :onRegionChange="handleRegionChange" 
          />
      </div>
      <div class="flex flex-col gap-3 pt-3 sm:pt-5">
        <div class="flex justify-center font-bold text-[40px]">{{ selectedRegion }}</div>
        <div class="flex flex-wrap gap-2 justify-center">
          <div class="w-64" v-for="(item, index) in dataArray" :key="index">
            <CardComponent :data="item" />
          </div>
        </div>
      </div>
      <div class="flex bg-gray-300 justify-center rounded-lg p-3 backdrop-filter backdrop-blur-sm bg-opacity-10 shadow-lg">
        <ChartComponent :weatherData="dataArray" />
      </div>
      </div>
      <Footer />
    </div>
</template>