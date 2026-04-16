<?php 
require_once "../config.php";
include "../includes/header.php";
?>

<style>
.installment-page{
    min-height:80vh;
    background:linear-gradient(180deg,#c68bdc,#f1f2f6);
    padding:60px 20px;
}

.installment-box{
    max-width:800px;
    margin:auto;
    background:#fff;
    padding:40px;
    border-radius:18px;
    box-shadow:0 15px 30px rgba(0,0,0,0.15);
}

.installment-box h2{
    text-align:center;
    margin-bottom:10px;
}

.installment-box p{
    text-align:center;
    color:#777;
    margin-bottom:25px;
}

.info{
    background:#f6f6ff;
    padding:15px;
    border-radius:10px;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:18px;
}

.form-group label{
    font-weight:600;
}

.form-control{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ddd;
    margin-top:5px;
}

.btn-calc{
    width:100%;
    padding:14px;
    background:#c68bdc;
    color:#fff;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}

.result{
    margin-top:25px;
    background:#eaf7ff;
    padding:18px;
    border-radius:10px;
    display:none;
}
.result h3{
    color:#333;
}
</style>

<section class="installment-page">
    <div class="installment-box">

        <h2>Trả góp xe đạp</h2>
        <p>Mua xe dễ dàng – Trả góp nhẹ nhàng mỗi tháng 🚴</p>

        <div class="info">
            ✔ Trả trước tối thiểu 30% <br>
            ✔ Lãi suất 1.5% / tháng <br>
            ✔ Thời gian 3 – 12 tháng
        </div>

        <div class="form-group">
            <label>Giá xe (VNĐ)</label>
            <input type="number" id="price" class="form-control" placeholder="Ví dụ: 15000000">
        </div>

        <div class="form-group">
            <label>Trả trước (%)</label>
            <input type="number" id="deposit" class="form-control" value="30">
        </div>

        <div class="form-group">
            <label>Số tháng trả góp</label>
            <select id="months" class="form-control">
                <option value="3">3 tháng</option>
                <option value="6">6 tháng</option>
                <option value="9">9 tháng</option>
                <option value="12">12 tháng</option>
            </select>
        </div>

        <button class="btn-calc" onclick="calculateInstallment()">Tính trả góp</button>

        <div class="result" id="resultBox">
            <h3>Kết quả</h3>
            <p id="depositResult"></p>
            <p id="monthlyResult"></p>
            <p id="totalResult"></p>
        </div>

    </div>
</section>

<script>
function calculateInstallment(){
    let price = parseFloat(document.getElementById("price").value);
    let depositPercent = parseFloat(document.getElementById("deposit").value);
    let months = parseInt(document.getElementById("months").value);

    if(!price){
        alert("Vui lòng nhập giá xe");
        return;
    }

    let deposit = price * depositPercent / 100;
    let loan = price - deposit;
    let interest = loan * 0.015 * months;
    let total = loan + interest;
    let monthly = total / months;

    document.getElementById("resultBox").style.display="block";
    document.getElementById("depositResult").innerHTML =
        "Trả trước: <b>" + deposit.toLocaleString() + " VNĐ</b>";
    document.getElementById("monthlyResult").innerHTML =
        "Mỗi tháng trả: <b>" + Math.round(monthly).toLocaleString() + " VNĐ</b>";
    document.getElementById("totalResult").innerHTML =
        "Tổng tiền trả góp: <b>" + Math.round(total).toLocaleString() + " VNĐ</b>";
}
</script>

<?php include "../includes/footer.php"; ?>