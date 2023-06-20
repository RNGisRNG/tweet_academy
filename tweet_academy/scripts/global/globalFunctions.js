function sendAjax(url, method, data, callback) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        success: (data) => {
            callback(data);
        },
        error: (error) => {
            console.log(error);
        },
    });
}

function logout() {
    const data = {
        action: 'logout',
    }
    $.post('../controller/controller.php', data, (response) => {
        const json = JSON.parse(response)
        if (json.success) {
            window.location.href = '../index.php'
        }
    })
}

function redirectMessage() {
    window.location.href = '../pages/messages.php'
}

function redirectProfile() {
    window.location.href = '../pages/profile.php'
}

function redirectSettings() {
    window.location.href = "../pages/settings.php"
}

function redirectHome() {
    window.location.href = "../pages/home.php"
}

function deleteAccount() {
    $.post("../controller/controller.php", {action: "delete_user"}, (response) => {
        const json = JSON.parse(response)
        if (json.success) {
            window.location.href = "../index.php"
        } else {
            console.log(json.msg)
        }
    })
}