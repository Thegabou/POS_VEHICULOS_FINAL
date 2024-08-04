
    const form = document.getElementById('globalVariableForm');
    const messageDiv = document.getElementById('message');
    const variablesList = document.getElementById('variablesList');

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log('form:', form);
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': formData.get('_token'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageDiv.innerHTML = '<p>' + data.success + '</p>';
                const newVariable = document.createElement('li');
                newVariable.id = 'variable-' + data.key;
                newVariable.innerHTML = `<strong>${data.key}:</strong> ${data.value} <button class="deleteVariable" data-key="${data.key}">Delete</button>`;
                variablesList.appendChild(newVariable);
            } else {
                messageDiv.innerHTML = '<p>' + data.error + '</p>';
            }
        });
    });

    variablesList.addEventListener('click', function (e) {
        if (e.target.classList.contains('deleteVariable')) {
            const key = e.target.getAttribute('data-key');

            fetch('/global-variables/' + key, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<p>' + data.success + '</p>';
                    const variableItem = document.getElementById('variable-' + data.key);
                    variableItem.remove();
                } else {
                    messageDiv.innerHTML = '<p>' + data.error + '</p>';
                }
            });
        }
    });

