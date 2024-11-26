// require('./bootstrap');

/** 
 * Completa el formulario de login con las opciones seguientes a este 
 * Vista: auth.login 
 */
document.querySelectorAll('.autocompleteLogin').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();
        completeLoginForm(this.textContent);
    })
});

function completeLoginForm(email) {
    let emailInput = document.getElementById('email');
    let passwordInput = document.getElementById('password');

    emailInput.value = email;
    passwordInput.value = 'password';
}
/* Fin: Completa el formulario de login con las opciones seguientes a este */

/** 
 * Añade categoría al elemento input 'categorias' en el formulario de creación de las recetas 
 * Vista: recetas.create 
 */
document.querySelectorAll('.botonCategoria').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();

        let id = this.dataset.idValue;
        let text = this.textContent;
        
        let div = document.getElementById('divInputCategorias');

        if (div.hasChildNodes()) {
            let children = div.children;
            
            for (const node of children) {
                if (node.getAttribute('value') == id) {
                    return;
                }
            }
        }

        div.insertAdjacentHTML('beforeend', 
            '<span class="badge text-bg-secondary rounded-1 fw-normal p-2 ms-1 mt-1" value="'+id+'">'+text+'<button class="btn ms-1" onclick="deleteCategoriaElement(event, this)" title="Eliminar categoria"><i class="bi bi-x"></i></button></span><input type="hidden" name="categorias[]" value="'+id+'">'
        );
        this.disabled = true;
    })
});
/* Fin: Añade categoría al elemento input 'categorias' en el formulario de creación de las recetas */

/**
 * Borra elemento input y el input hidden en el formulario de creación de las recetas. 
 * Vista: recetas.create
 */
function deleteCategoriaElement(event, target) {
    event.preventDefault();

    let hiddenInputs = document.getElementsByName('categorias[]');

    for (const input of hiddenInputs) {
        if (input.getAttribute('value') == target.parentNode.getAttribute('value')) {
            input.remove();
            break;
        }
    }

    let botones = document.getElementsByClassName('botonCategoria');

    for (const boton of botones) {
        if (boton.textContent == target.parentNode.textContent) {
            boton.disabled = false;
            break;
        }
    }

    target.parentNode.remove();
}
/* Fin: Borra elemento input y el input hidden en el formulario de creación de las recetas.  */

/** 
 * Añade elemento input para añadir pasos o ingredientes en el formulario de creación de las recetas 
 * Vista: recetas.create 
 */
document.querySelectorAll('.addListElement').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();
    
        let target = this.dataset.elementType;

        let input = document.getElementById(target);
        let clone = input.cloneNode(true);
        
        let lastInput = document.querySelectorAll('.'+target+'sInputList');
        lastInput = lastInput.item(lastInput.length-1);
        
        clone.children[0].textContent = '';
        clone.children[1].children[0].children[0].value = '';
        clone.children[1].children[0].insertAdjacentHTML('beforeend', '<button class="btn btn-light border input-group-text" onclick="deleteRecetaElement(event, this)" title="Eliminar '+target+'"><i class="bi bi-x"></i></button>');

        lastInput.after(clone);
    })
});
/* Fin: Añade elemento input para añadir pasos o ingredientes en el formulario de creación de las recetas */

/** 
 * Borra elemento input para añadir pasos o ingredientes en el formulario de creación de las recetas.
 * Vista: recetas.create 
 */
function deleteRecetaElement(event, target) {
    event.preventDefault();
    target.parentNode.parentNode.parentNode.remove();
}
/* Fin: Borra elemento input para añadir pasos o ingredientes en el formulario de creación de las recetas. */

/** 
 * Muestra el formulario de edición de una valoración en la vista de muestra de una receta. 
 * Vista: recetas.show
 */
document.querySelectorAll('.editValoracion').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();
        
        let valoracionContent = this.parentNode.parentNode.parentNode.getElementsByClassName('valoracionContent')[0];
        let textAreaInput = this.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('textoValoracion')[0];

        textAreaInput.innerHTML = valoracionContent.innerHTML;
        textAreaInput.parentNode.classList.remove('d-none');
        valoracionContent.parentNode.parentNode.classList.add('d-none');
    })
});

/* Cancela la acción anterior. */
document.querySelectorAll('.cancelarEditValoracion').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();

        let valoracionContent = this.parentNode.parentNode.parentNode.getElementsByClassName('valoracionContent')[0];
        let textAreaInput = this.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('textoValoracion')[0];

        textAreaInput.parentNode.classList.add('d-none');
        valoracionContent.parentNode.parentNode.classList.remove('d-none');
    })
});
/* Fin: Edición de una valoración en la vista de muestra de una receta. */

/** 
 * Funcionalidad para añadir el rating en el formulario de una valoración en la vista de muestra de una receta. 
 * Vista: recetas.show 
 */
document.querySelectorAll('.estrellaInput').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();

        this.classList.remove('bi-star');
        this.classList.add('bi-star-fill');

        let nextSibling = this.nextElementSibling;
        let prevSibling = this.previousElementSibling;

        while(nextSibling) {
            nextSibling.classList.remove('bi-star-fill');
            nextSibling.classList.add('bi-star');
            nextSibling = nextSibling.nextElementSibling;
        }

        while(prevSibling) {
            prevSibling.classList.remove('bi-star');
            prevSibling.classList.add('bi-star-fill');
            prevSibling = prevSibling.previousElementSibling;
        }

        document.getElementsByName('rating')[0].value = this.dataset.value;
    })
});
/* Fin: Funcionalidad para añadir el rating en el formulario de una valoración en la vista de muestra de una receta. */

/**
 * Funcionalidad para añadir la receta a favoritos en la vista de muestra de una receta y en algunos componentes.
 * Componente: receta-card
 * Componente: receta-list-item
 * Vista: recetas.show
 */
document.querySelectorAll('.corazonInput').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();

        getData(this);
    })
});

function changeFavouriteState(target) {
    
    let form = target.closest("form");

    if (target.classList.contains("bi-heart")) {
        target.classList.remove("bi-heart");
        target.classList.add("bi-heart-fill");

        let action = form.action.slice(0, -8)+'unfavorite';
        form.action = action;
        
    } else if (target.classList.contains("bi-heart-fill")) {
        target.classList.remove("bi-heart-fill");
        target.classList.add("bi-heart");

        let action = form.action.slice(0, -10)+'favorite';
        form.action = action;
    }
}
/* Fin: Funcionalidad para añadir la receta a favoritos en la vista de muestra de una receta y en algunos componentes. */

/* Petición ajax */
async function getData(target) {

    token = document.head.querySelector('meta[name="csrf-token"]').content;

    let form = target.closest("form");
    let formData = new FormData(form);
    let url = form.action;
    let method = form.method;

    try {
        const response = await fetch(url, {
            headers: {
                "X-CSRF-TOKEN": token
            },
            method: method,
            body: formData
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
  
        const json = await response.json();
        
        changeFavouriteState(target);
    } catch (error) {
        console.error(`Error message: ${error.message}`);
    }
}
/* Fin: Petición ajax */

/**
 * Muestra el formulario de edición de una categoría existente.
 * Vista: categorias.index
 */
document.querySelectorAll('.editCategoria').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();
        
        let categoriaContent = this.parentNode.parentNode.parentNode.getElementsByClassName('categoriaContent')[0];
        let textInput = this.parentNode.parentNode.parentNode.getElementsByClassName('textoCategoria')[0];
        this.parentNode.parentNode.classList.add('d-none');

        textInput.value = categoriaContent.innerHTML;
        textInput.parentNode.classList.remove('d-none');
        categoriaContent.parentNode.classList.add('d-none');
    })
});

/* Cancela la acción anterior. */
document.querySelectorAll('.cancelarEditCategoria').forEach(function (e) {
    e.addEventListener('click', function(e) {
        e.preventDefault();

        let categoriaContent = this.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('categoriaContent')[0];
        let textInput = this.parentNode.parentNode.parentNode.getElementsByClassName('textoCategoria')[0];
        console.log(this.parentNode.parentNode.parentNode);
        this.parentNode.parentNode.parentNode.parentNode.getElementsByClassName('categoriaInfo')[0].classList.remove('d-none');

        textInput.parentNode.classList.add('d-none');
        categoriaContent.parentNode.classList.remove('d-none');
    })
});
/* Fin: Muestra el formulario de edición de una categoría existente.*/