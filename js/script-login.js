// Label And Inputs :
const userCode = document.getElementById("userCode");
const clearInput = document.getElementById("clearInput");

// Message Error:
const messageError1 = document.getElementById("messageError1");

// Parent Inputs :
const div1 = document.getElementById("div1");

// Form :
const formLogin = document.getElementById("fsdpElement");

// Condition For Send Data :
let validationLogin = false;

formLogin.addEventListener("submit", (formlogin)=>{
    if (div1.classList.contains("success") === true) {
        validationLogin = true;
    }


    if (validationLogin  === false) {
        formlogin.preventDefault();
    } 
});

// Button Send Data :
const buttonSendData = document.getElementById("bsdpElement");

buttonSendData.addEventListener("click", ()=> {
    var userCodeValue = userCode.value.trim();
    const regex = /^[A-Za-z]{2}\d{2}[A-Za-z]{2}$/;

    if (userCodeValue === '') {
        div1.classList.remove("success");
        userCode.classList.add('error-input');
        messageError1.classList.add("show-error-message");
    } else if (!regex.test(userCodeValue)) {
        div1.classList.remove("success");
        userCode.classList.add('error-input');
        messageError1.classList.add("show-error-message");
    } else if (regex.test(userCodeValue)) {
        div1.classList.add("success");
        userCode.classList.remove('error-input');
        messageError1.classList.remove("show-error-message");
    }

});


userCode.addEventListener("input", ()=> {
    var userCodeValue = userCode.value.trim();
    const regex = /^[A-Za-z]{2}\d{2}[A-Za-z]{2}$/;

    if (!regex.test(userCodeValue)) {
        div1.classList.remove("success");
        userCode.classList.add('error-input');
        messageError1.classList.add("show-error-message");
    } else if (regex.test(userCodeValue)) {
        div1.classList.add("success");
        userCode.classList.remove('error-input');
        messageError1.classList.remove("show-error-message");
    }
});


userCode.addEventListener("input", ()=> {
    var userCodeValue = userCode.value.trim();
    const regex = /^[A-Za-z]{2}\d{2}[A-Za-z]{2}$/;

    if (!regex.test(userCodeValue)) {
        clearInput.classList.add("show-icon-clear");
    } else if (regex.test(userCodeValue)) {
        clearInput.classList.remove("show-icon-clear");
    }
});

userCode.addEventListener("write", ()=> {
    var userCodeValue = userCode.value.trim();
    const regex = /^[A-Za-z]{2}\d{2}[A-Za-z]{2}$/;

    if (!regex.test(userCodeValue)) {
        clearInput.classList.add("show-icon-clear");
    } else if (regex.test(userCodeValue)) {
        clearInput.classList.remove("show-icon-clear");
    }
});

userCode.addEventListener("blur", ()=> {
    var userCodeValue = userCode.value.trim();
    const regex = /^[A-Za-z]{2}\d{2}[A-Za-z]{2}$/;

    if (!regex.test(userCodeValue)) {
        clearInput.classList.add("show-icon-clear");
    } else if (regex.test(userCodeValue)) {
        clearInput.classList.remove("show-icon-clear");
    }
});

clearInput.addEventListener("click", ()=> {
    userCode.value = "";
});