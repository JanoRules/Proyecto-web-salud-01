fetch('get-notifications.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(notification => {
            console.log('Recordatorio:', notification.message);
        });
    });
