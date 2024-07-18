function loadContent(url) {
    fetch(url)
        .then(response => response.text())
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            attachSearchHandler();
        })
        .catch(error => console.warn(error));
}

function filterFunction(searchInputId, dropdownMenuId) {
    var input, filter, div, a, i;
    input = document.getElementById(searchInputId);
    filter = input.value.toUpperCase();
    div = document.getElementById(dropdownMenuId);
    a = div.getElementsByClassName("dropdown-item");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
        } else {
            a[i].style.display = "none";
        }
    }
}

function selectOption(displayInputId, hiddenInputId, element) {
    var displayInput = document.getElementById(displayInputId);
    var hiddenInput = document.getElementById(hiddenInputId);
    displayInput.value = element.textContent;
    hiddenInput.value = element.getAttribute('data-id');
}

function toggleDropdown(dropdownMenuId) {
    var dropdownMenu = document.getElementById(dropdownMenuId);
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
}

// Cerrar el dropdown si se hace clic fuera
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        var dropdowns = document.getElementsByClassName('dropdown-menu');
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = 'none';
        }
    }
});
