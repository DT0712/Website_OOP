function editPersonal(){
    alert('Chỉnh sửa thông tin cá nhân');
}

function editAddress(){
    alert('Chỉnh sửa địa chỉ');
}

function switchTab(id){
    localStorage.setItem('activeTab', id);

    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));

    document.getElementById(id).classList.add('active');
    document.querySelector(`a[href="#${id}"]`).classList.add('active');
}

window.onload = function(){
    const tab = localStorage.getItem('activeTab') || 'profile';
    switchTab(tab);
}