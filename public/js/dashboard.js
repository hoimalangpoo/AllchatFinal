document.addEventListener("DOMContentLoaded", function() {
    $(document).ready(function() {
        // โหลดข้อมูลและสร้างกราฟตอนแรก
        loadDataAndCreateChart();
        loadDataNumber();
    function loadDataAndCreateChart() {
        $.ajax({
            url: 'getdata',
            dataType: 'json',
            success: function(data) {
               
                createBarChart2(data);
            }
        });
        $.ajax({
            url: 'getreplydata',
            dataType: 'json',
            success: function(data) {
                
                createBarChart(data);
            }
        });
    }
    function loadDataNumber() {
        $.ajax({
            url: 'dropdownfilter',
            dataType: 'json',
            success: function(data) {
                // ประมวลผลข้อมูลและสร้างกราฟ กำหนดไว้เพื่อเอาไอดีพวกนี้ไปแทนที่
                $('#totalContacts').text(data.totalContacts);
                $('#totalQuestion').text(data.totalQuestion);
                $('#totalReplies').text(data.totalReplies);
            }
        });
    }

    // ****************************************************FUNCTION CREATE CHARTS**************************************************
    function createBarChart(data) {    
        var monthNamesThai = [
            "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];
        data = data.filter(function(item) {
            var date = new Date(item.month_year);
            var currentDate = new Date();
            var maxDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 6, 1); 
            return date >= maxDate;
        });
        var month_year = data.map(function(item) {
            var date = new Date(item.month_year);
            var monthIndex = date.getMonth();
            var year = date.getFullYear() + 543; 
            return monthNamesThai[monthIndex] + " " + year;
        });
    
        var message_count = data.map(function(item) {
            return item.message_count //เอาจำนวนข้อความ
        });
    
        var ctx = document.getElementById("barchart").getContext("2d");//ตั้งไอดี
        var chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: month_year,
                datasets: [{
                    label: "จำนวนข้อความ",
                    borderWidth: 1,
                    backgroundColor: '#ffc107',
                    borderColor: '#ffc107',
                    data: message_count,
                }],
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    function createBarChart2(data){
                    var monthNamesThai = [
                        "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                        "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
                      ];
                      data = data.filter(function(item) {
                        var date = new Date(item.month_year);
                        var currentDate = new Date();
                        var maxDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 6, 1); 
                        return date >= maxDate;
                    });
                      var month_year = data.map(function(item){
                          var date = new Date(item.month_year);
                          var monthIndex = date.getMonth();
                          var year = date.getFullYear() + 543; 
                          return monthNamesThai[monthIndex] + " " + year;
                      });
                    var message_count = data.map(function(item){
                        return item.message_count
                    });
                var ctx = document.getElementById("linechart").getContext("2d");
                var chart = new Chart(ctx, {
                    type: "bar",
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
                
        
// ****************************************************FUNCTION CREATE CHARTS**************************************************


// **************************************************************FILTER USER************************************
    }
    $(".userlist").on('click', function(){

        $(".userlist").removeClass("active");
        $(this).addClass("active");

        //เอาไอดีไปหาในฐานข้อมูล
        var id = $(this).attr('id');
        console.log(id);
        
        let fetchData = function() {
            $.post("/getreplydata", {
                filter_user_id: id
              },
              function(data, status) {
                console.log(data)
                 updateBarChart(data);
              });
          }
          fetchData();
    });
   
  // **************************************************************FILTER USER************************************





  // **************************************************************FILTER DROPDOWN************************************

  $('#lineOaDropdown').change(function() {
    var selectedValue = $(this).val();//ค่าที่เลือกเพื่อส่ง
    console.log(selectedValue);
    $.ajax({
        type: 'POST',
        url: 'dropdownfilter',
        data: { selectedValue: selectedValue },
        dataType: 'json',
        success: function(response) {
            $('#totalContacts').text(response.totalContacts);
            $('#totalQuestion').text(response.totalQuestion);
            $('#totalReplies').text(response.totalReplies);
            updateBarChart(response.BarchartData);
            updateBarChart2(response.LinechartData);
            updateTable(response.userData);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
//ลบตัวเดิม
function updateBarChart(data) {
    var existingChart = Chart.getChart('barchart');
if (existingChart) {
    existingChart.destroy();
}
//สร้างตัวใหม่
    createBarChart(data);
}
function updateBarChart2(data) {
    var existingChart = Chart.getChart('linechart');
if (existingChart) {
    existingChart.destroy();
}

    createBarChart2(data);
}
//สร้างตารางใหม่
function updateTable(userData) {
    var tbody = document.querySelector("#userTable tbody");
    tbody.innerHTML = ""; 
    var headerRow = document.createElement("tr"); // สร้างแถวใหม่สำหรับ header
    var nameHeader = document.createElement("th");
    nameHeader.textContent = "ชื่อผู้ใช้";
    var messageCountHeader = document.createElement("th");
    messageCountHeader.textContent = "จำนวนการตอบกลับ";
    headerRow.appendChild(nameHeader);
    headerRow.appendChild(messageCountHeader);
    
//loop สร้างแถว
    userData.forEach(function(user) {
        var row = document.createElement("tr");
        var nameCell = document.createElement("td");
        nameCell.textContent = user.name;
        nameCell.className = "filterusergroup"; 
        nameCell.id = user._id + "lineOAid" + user.from_ch;
        var messageCountCell = document.createElement("td");
        messageCountCell.className = "filternumuserlist";
        messageCountCell.textContent = user.message_count;

        row.appendChild(nameCell);
        row.appendChild(messageCountCell);
        tbody.appendChild(row);
    });

  

    $(".filterusergroup").on('click', function(){

        $(".filterusergroup").removeClass("active");
        $(this).addClass("active");
        
       var raw = $(this).attr('id');
        var lineOAid = $(this).attr('id').split("lineOAid")[1];
        var userid = $(this).attr('id').split("lineOAid")[0];
    
        console.log('userid: ' + userid + ', lineOAid: ' + lineOAid);
        console.log(raw);
     
        let fetchData = function() {
            $.post("/getreplydata", {
                filter_group_userid: userid,
                filter_group_lineOAid : lineOAid
              },
              function(data, status) {
                console.log(data)
                 updateBarChart(data);
              });
          }
          fetchData();
    });


    
}

//******************************************************************************************************* */






});
});
