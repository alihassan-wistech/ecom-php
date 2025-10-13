document.addEventListener("DOMContentLoaded", () => {

    const logoutBtn = document.querySelector("#logout-btn")
    logoutBtn.addEventListener("click", async () => {
        const response = await fetch("/admin/logout")
        window.location.href = "/admin"
    })

    const sidebarToggler = document.querySelector("#sidebarToggle")
    const sidebar = document.querySelector("#accordionSidebar")
    const key = "TOGGLED"

    let data = JSON.parse(localStorage.getItem("TOGGLED")) || {
        value: false
    }

    let {
        value
    } = data

    if (value == true) {
        sidebar.classList.add("toggled")
    } else {
        sidebar.classList.remove("toggled")
    }

    sidebarToggler.addEventListener("click", () => {
        data.value = !value
        localStorage.setItem("TOGGLED", JSON.stringify(data))
    })

    const navItems = document.querySelectorAll(".nav-item")
    // console.log(navItems)
    navItems.forEach(item => {
        const links = item.querySelectorAll(".nav-link, .collapse-item")
        links.forEach(link => {
            if (window.location.href == link.href) {
                item.classList.add("active")
            }
        })
    })


    // let conn = new WebSocket('ws://localhost:8080');
    // const notificationBox = document.querySelector("#notification")
    // conn.onopen = function (e) {
    //     console.log("Connection established!");
    // };

    // conn.onmessage = function (e) {
    //     let message = e.data

    //     if (message == "New Order Created") {
    //         notificationBox.innerHTML += `<div class="alert alert-success alert-dismissible fade show" role="alert">
    //           <strong>New Order Created</strong>
    //           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //             <span aria-hidden="true">&times;</span>
    //           </button>
    //         </div>`
    //     }
    // };

    const searchbar = document.querySelector("#searchbar")
    const suggestionsList = document.querySelector("#suggestions")
    const searchbarForm = document.querySelector("#searchbar-form")

    let values = {
        query: ""
    }

    const getData = debounce(
        async (e) => {
            try {
                let value = e.target.value
                values.query = value
                const input = new FormData()
                input.append("query", value)
                const response = await fetch("/admin/search", {
                    method: "POST",
                    body: input
                })
                const data = await response.json()
                const result = JSON.parse(data.message);

                let optionsHTML = ""
                for (n in result) {
                    result[n].forEach(item => {
                        optionsHTML += `<option value="${item.name}">${item.name} : ${n}</option>`
                    })
                }
                suggestionsList.innerHTML = optionsHTML

            } catch (error) {

            }

        }, 500)

    function debounce(callback, delay) {
        let timer
        return function () {
            let context = this
            let args = arguments
            clearTimeout(timer)
            timer = setTimeout(() => {
                callback.apply(context, args)
            }, delay)
        }
    }

    searchbar.addEventListener("input", getData)

    window.addEventListener("keydown", (e) => {
        if (e.ctrlKey && e.key == "k") {
            e.preventDefault()
            searchbar.focus()
        }
    })
});