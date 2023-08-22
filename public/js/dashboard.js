document.addEventListener("DOMContentLoaded", function() {
    const totalValueElement = document.getElementById("totalValue");
    const totalValue = parseInt(totalValueElement.textContent);

    // ตัวอย่างโค้ดสร้างกราฟด้วย Chart.js
    const labels = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม']; // ตัวอย่างเท่านั้น
    const data = [10, 20, 15]; // ตัวอย่างเท่านั้น

    const ctx = document.getElementById("lineChart").getContext("2d");
    const lineChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [{
                label: "ข้อความที่ตอบกลับ",
                data: data,
                borderColor: "rgba(75, 192, 192, 1)",
                fill: false
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
