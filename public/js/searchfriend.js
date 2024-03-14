
$(document).ready(function() {
    $('#searchButton').click(function() {
        var friendSearchValue = $('#frienduser').val();
      
        console.log(friendSearchValue);
        $.ajax({
            type: 'POST',
            url: '/searchfriend',
            data: { friendSearch: friendSearchValue },
            success: function(response) {
                console.log(response);
                $('#searchResults').html(response); // ใช้ .html() เพื่อเปลี่ยนแทนที่ข้อมูลใน ul
                $('#modalAdd').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
