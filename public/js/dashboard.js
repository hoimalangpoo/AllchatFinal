document.addEventListener("DOMContentLoaded", function() {

  $.ajax({
    url: 'getdata',
    dataTpe: 'json',
    success: function(data){

        console.log(data);
        var month_year = data.map(function(item){
            return item.month_year
        });

        var message_count = data.map(function(item){
            return item.message_count
        });

        var ctx = document.getElementById("lineChart").getContext("2d");
        var chart = new Chart(ctx, {
            type: "line",
            data: {
                labels: month_year,
                datasets:[{
                    label: "จำนวนข้อความ",
                    borderWidth: 1,
                    backgroundColor: '#ffc107',
                    borderColor: '#ffc107',
                    data: message_count,
                }],
            },
            options:{
                scales:{
                    x:{
                        beginAtZero: true
                    },
                    y:{
                        beginAtZero: true
                    }
                }
            }
        })
    }
  })

});
