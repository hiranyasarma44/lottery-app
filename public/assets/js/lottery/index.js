import { createApp } from 'vue'
const assetUrl = document.getElementById('index-script').getAttribute('data-asset-url')
createApp({
  data() {
    return {
      items: [
        {
          name: 'Lottery 1',
          src: assetUrl+'/images/card/event_1.jpg',
          date: '10/10/2022',
          time: '9:30 am'
        },
        {
          name: 'Lottery 2',
          src: assetUrl+'/images/card/event_2.jpg',
          date: '11/10/2022',
          time: '9:30 am'
        },
        {
          name: 'Lottery 3',
          src: assetUrl+'/images/card/event_3.jpg',
          date: '12/10/2022',
          time: '9:30 am'
        }
      ]
    }
  }
}).mount('#lottery')