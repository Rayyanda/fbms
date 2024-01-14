// /* globals Chart:false */

// (() => {
//   'use strict'

//   // Graphs
//   const ctx = document.getElementById('myChart')
//   // eslint-disable-next-line no-unused-vars
//   const myChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//       labels: [
//         'Sunday',
//         'Monday',
//         'Tuesday',
//         'Wednesday',
//         'Thursday',
//         'Friday',
//         'Saturday'
//       ],
//       datasets: [{
//         data: [
//           15339,
//           21345,
//           18483,
//           24003,
//           23489,
//           24092,
//           12034
//         ],
//         lineTension: 0,
//         backgroundColor: 'transparent',
//         borderColor: '#007bff',
//         borderWidth: 4,
//         pointBackgroundColor: '#007bff'
//       }]
//     },
//     options: {
//       plugins: {
//         legend: {
//           display: true
//         },
//         tooltip: {
//           boxPadding: 3
//         }
//       }
//     }
//   })
// })();
//bar

        //line
            



document.getElementById('darkTheme').addEventListener('click',()=>{
    document.getElementById('html').dataset.bsTheme = "dark";
    localStorage.setItem("data-bs-theme","dark");
})
document.getElementById('lightTheme').addEventListener('click',()=>{
    document.getElementById('html').dataset.bsTheme = "light";
    localStorage.setItem("data-bs-theme","light");
})



window.addEventListener('load',()=>{
    document.getElementById('html').dataset.bsTheme = localStorage.getItem('data-bs-theme');
})

document.getElementById('btnEye').addEventListener('click',()=>{
    const btn = document.getElementById('passwordLogin');
    if(document.getElementById('passwordLogin').type ==='text'){
        document.getElementById('eyeOpen').className = "bi bi-eye"
        btn.type = "password"
        document.getElementById('btnEye').title = "tampilkan password"
    }else{
        document.getElementById('eyeOpen').className = "bi bi-eye-slash"
        btn.type = "text"
        document.getElementById('btnEye').title = "sembunyikan password"
    }
})
