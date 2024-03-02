<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>

<body>
  <section class=" min-vh-100">
    <?php require base_path('views/navbar/navbar.php'); ?>
    <div class="container-fluid">
      <div class="row mt-3">
      <?php require base_path('views/navbar/slidebar.php'); ?>
        <div class="col d-flex justify-content-center align-items-center ">
          <div class="card-sm  ">
            <div class="card-body ">
              <div class="row d-flex justify-content-center">
                <div class="col-sm-5">
                  <img src="ภาพ/avatar2.png" class="w-100 rounded-circle">
                </div>
              </div>
              <h2 class="data mt-5">ข้อมูลส่วนตัว</h2>
              <hr>
              <table class="table table-borderless my-4">
                <tbody>
                  <tr>
                    <td>
                      <h5>ชื่อผู้ใช้</h5>
                    </td>
                    <td><?= $account['name'] ?></td>
                    <td>
                      <button type="button" class="btn bg-warning" data-bs-toggle="modal" data-bs-target="#modalEditname">
                        แก้ไข
                      </button>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h5>อีเมล</h5>
                    </td>
                    <td><?= $account['email'] ?></td>
                  </tr>
                  <tr>
                    <td>
                      <h5>เบอร์โทรศัพท์</h5>
                    </td>
                    <td><?= $account['telephone'] ?></td>
                  </tr>
                  <tr>
                    <td>
                      <h5>แผนก</h5>
                    </td>
                    <td><?= $account['agency'] ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="card translate">
        <textarea id="input_area" name="message" rows="2" >ลองทำการแปลภาษา</textarea>
        <br/>
        <button onclick="submit_thai2en()">แปลภาษาจากไทยเป็นอังกฤษ</button>

        
        <textarea id="translated_area" name="message" rows="1" ></textarea>
    </div>

</div>



    </div>
  </section>


 


 
<script>

function translate(sentences, targetDiv, from_lang ='th', to_lang='en'){
	
  
  sentences = sentences.replace(/\n/g, '<br>')
  let endPoint = `https://translate.googleapis.com/translate_a/single?client=gtx&sl=${from_lang}&tl=${to_lang}&dt=t&ie=UTF-8&oe=UTF-8&q=${encodeURIComponent(sentences)}` ;
						
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		var jsonText = JSON.parse(this.responseText);
		text = jsonText[0][0][0]
		text = text.replace(/<br>/g, '\n')
      targetDiv.innerHTML = "&nbsp;" + text;	  
    }
  };
  xhttp.open("GET", endPoint, true);
  xhttp.send();
}

function submit_thai2en(){		
	translate(input_area.value, translated_area)
}


</script>



  

  <!-----------------Modal Add friend---------------------------------------->

  <div class="modal fade" id="modalEditname" tabindex="-1" aria-labelledby="modalEditnameLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEditnameLabel">แก้ไขชื่อและหน่วยงาน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/updated_account" method="POST">
          <div class="modal-body">
            <div class="mb-3">
              <input type="text" name="renameuser" class="form-control" id="FormControlInput1" placeholder="กรอกชื่อผู้ใช้ใหม่" value="<?php echo $account['name'] ?>">
              <select name="agency" class="form-select" aria-label="Default select example">
                <option selected value="<?= $account['id'] ?>"><?= $account['agency'] ?></option>
                <option value="1">งานบริหารและสารสนเทศ</option>
                <option value="2">งานรับเข้าศึกษาและการตลาด</option>
                <option value="3">งานบริการและทะเบียนการศึกษา</option>
                <option value="4">งานหลักสูตรและสหกิจศึกษา</option>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button name="rename" type="submit" class="btn btn-warning">เสร็จสิ้น</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="js/bootstrap.esm.min.js"></script>

</body>
<style>
  body {
    background-image: url(ภาพ/background.jpg);
  }

  .social-login-element {
    width: 27rem;
    height: 3.75rem;
    font-size: 1.2rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    border-radius: 5px;
    border: 0.5px solid gray;
    display: flex;
    justify-content: center;
    align-items: center;

  }

  .social-login-element img {
    width: 1.875rem;
    height: 1.875rem;
    position: relative;
    top: 0;
    left: -0.625rem;
  }

  .social-login-element:hover {
    background-color: #fff9c4;
  }
</style>

</html>