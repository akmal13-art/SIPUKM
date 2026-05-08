function validateLoginForm(){
    let u = document.getElementById('username').value.trim();
    let p = document.getElementById('password').value.trim();
    if(u=="" || p==""){ alert("Semua field harus diisi!"); return false; }
    return true;
}

function validateRegisterForm(){
    let n = document.getElementById('nama').value.trim();
    let u = document.getElementById('username').value.trim();
    let p = document.getElementById('password').value.trim();
    if(n==""||u==""||p==""){ alert("Semua field harus diisi!"); return false; }
    if(p.length<6){ alert("Password minimal 6 karakter!"); return false; }
    return true;
}

function validatePengajuanForm(){
    let k = document.getElementById('keterangan').value.trim();
    if(k==""){ alert("Keterangan harus diisi!"); return false; }
    return true;
}
