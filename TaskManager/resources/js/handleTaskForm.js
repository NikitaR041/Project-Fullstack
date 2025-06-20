console.log("handleTaskForm.js подключён");

window.handleImageUpload = function(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('image-preview-container');
    previewContainer.innerHTML = "";

    if (files.length > 10) {
        alert("Нельзя загружать более 10 изображений.");
        event.target.value = '';
        return;
    }

    Array.from(files).forEach(file => {
        const img = new Image();
        img.src = URL.createObjectURL(file);

        img.onload = () => {
            if (img.width > 1000 || img.height > 1000) {
                alert(`Изображение "${file.name}" превышает допустимые размеры (1000x1000).`);
                event.target.value = '';
                previewContainer.innerHTML = "";
                return;
            }

            const wrapper = document.createElement("div");
            wrapper.className = "image-preview-card";
            wrapper.appendChild(img);
            previewContainer.appendChild(wrapper);
        };
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('deleteImageForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const imageId = document.getElementById('image_id').value;
        if (!imageId) return;

        const taskId = form.dataset.taskId;
        const action = `/tasks/${taskId}/images/${imageId}`;

        fetch(action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-HTTP-Method-Override': 'DELETE'
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.reload();
            } else {
                alert('Ошибка при удалении изображения');
            }
        });
    });
});
