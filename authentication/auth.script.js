const LoginForm = document.querySelector("#LoginForm")
const RegisterForm = document.querySelector("#RegisterForm")

document.querySelector(".registerToggle").addEventListener("click",()=>{
    LoginForm.classList.add("hidden")
    RegisterForm.classList.remove("hidden")
})
document.querySelector(".loginToggle").addEventListener("click",()=>{
    LoginForm.classList.remove("hidden");
    RegisterForm.classList.add("hidden")
})

