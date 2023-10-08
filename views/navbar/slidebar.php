<div class="col-sm-3 col-md-1 ">
    <div class="list-group ">
        <a href="/chat" class="list-group-item list-group-item-action fs-4 bi bi-chat-left-text " aria-current="true"></a>
        <a href="#" class="list-group-item list-group-item-action fs-4 bi bi-person-fill dropdown-toggle " id="list-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/addfriend">เพิ่มเพื่อน</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/chatfriend">ดูห้องสนทนา</a></li>
        </ul>

        <a href="#" class="list-group-item list-group-item-action fs-4 bi bi-people-fill dropdown-toggle" id="list-dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"">
            </a>
            <ul class=" dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/creategroup">สร้างกลุ่ม</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">กลุ่มการสนทนา</a></li>
            </ul>
            <a href="/dashboard" class="list-group-item list-group-item-action fs-4 bi bi-bar-chart-fill"></a>
            <a href="/setting" class="list-group-item list-group-item-action fs-4 bi bi-gear-fill <?= $_SERVER['REQUEST_URI'] === '/Allchat/setting.php' ? 'bg-warning' : 'bg-light' ?>"></a>
            <a href="/logout" class="list-group-item list-group-item-action fs-4 bi bi-box-arrow-right"></a>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<style>
    .list-group-item:hover {
        background-color: #ffe082 !important;
    }

    .dropdown-item:hover {
        background-color: #ffe082 !important;
    }
</style>