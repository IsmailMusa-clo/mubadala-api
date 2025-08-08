function store(url, data) {
    axios
        .post(url, data)
        .then((response) => {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();
        })
        .catch((error) => {
            if (error.response && error.response.data && error.response.data.errors !== undefined) {
                console.log(data);
                showErrorMessages(error.response.data.errors);
            } else if (error.response && error.response.data) {
                showMessage(error.response.data);
            } else {
               //
            }
        });
}

function storepart(url, data) {
    axios
        .post(url, data)
        .then((response) => {
            showMessage(response.data);
            clearForm();
            clearAndHideErrors();
        })
        .catch((error) => {
            if (error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else {
                showMessage(error.response.data);
            }
        });
}

function storeRoute(url, data) {
    axios.post(url, data, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then((response) => {
            window.location = response.data.redirect;
        })
        .catch((error) => {
            if (error.response.data.errors !== undefined) {
                showErrorMessages(error.response.data.errors);
            } else {
                showMessage(error.response.data);
            }
        });
}

function storeRedirect(url, data, redirectUrl) {
    axios
        .post(url, data)
        .then((response) => {
            console.log(response);
            if (redirectUrl != null) {
                window.location.href = redirectUrl;
            }
        })
        .catch((error) => {
            console.log(error.response);
        });
}

function update(url, data, redirectUrl) {
    axios
        .put(url, data)
        .then((response) => {
            console.log(response);
            if (redirectUrl != null) {
                window.location.href = redirectUrl;
            }
        })
        .catch((error) => {
            console.log(error.response);
        });
}

function updateRoute(url, data) {
    axios
        .put(url, data)
        .then((response) => {
            console.log(response);
            window.location = response.data.redirect;
        })
        .catch((error) => {
            console.log(error.response);
        });
}

function updateReload(url, data, redirectUrl) {
    axios
        .put(url, data)
        .then((response) => {
            console.log(response);
            location.reload();
        })
        .catch((error) => {
            console.log(error.response);
        });
}

function updatePage(url, data) {
    axios
        .post(url, data)
        .then((response) => {
            console.log(response);
            location.reload();
        })
        .catch((error) => {
            console.log(error.response);
        });
}

function confirmDestroy(url, td) {
    Swal.fire({
        title: "Are you sure you want to delete?",
        text: "You can't undo it",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            destroy(url, td);
            Swal.fire({
                position: "center",
                icon: "success",
                title: "The deletion was completed successfully",
                showConfirmButton: false,
                timer: 2000,
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "The deletion failed.",
                showConfirmButton: false,
                timer: 1500,
            });
        }
    });
}

function destroy(url, td) {
    axios
        .delete(url)
        .then((response) => {
            console.log(response.data);
            td.closest("tr").remove();
        })
        .catch((error) => {
            console.log(error.response);
        });
}

function showErrorMessages(errors) {
    document.getElementById("error_alert").hidden = false;
    var errorMessagesUl = document.getElementById("error_messages_ul");
    errorMessagesUl.innerHTML = "";

    for (var key of Object.keys(errors)) {
        var newLI = document.createElement("li");
        newLI.appendChild(document.createTextNode(errors[key]));
        errorMessagesUl.appendChild(newLI);
    }
}

function clearAndHideErrors() {
    document.getElementById("error_alert").hidden = true;
    var errorMessagesUl = document.getElementById("error_messages_ul");
    errorMessagesUl.innerHTML = "";
}

function clearForm() {
    document.getElementById("create_form").reset();
}

function showMessage(data) {
    console.log(data);
    Swal.fire({
        position: "center",
        icon: data.icon,
        title: data.title,
        showConfirmButton: false,
        timer: 1500,
    });
}
