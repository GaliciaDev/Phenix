// Función para obtener el valor de una clave anidada en un objeto
function getNestedValue(obj, key) {
    return key.split('.').reduce((o, i) => (o ? o[i] : null), obj) || null;
}

// Función para actualizar los elementos <meta> con atributos personalizados
function updateMetaTags(data, document) {
    document.querySelectorAll('[data-mt-fb], [data-mt-twitter]').forEach(element => {
        const platform = element.getAttribute('data-mt-fb') ? 'facebook' : 'twitter';
        const key = element.getAttribute(`data-mt-${platform}`);
        const value = getNestedValue(data.meta[platform], key);
        if (value) {
            element.setAttribute('content', value);
        }
    });
}

// Función para actualizar los elementos <link> y <img> con atributos personalizados
function updateAttributes(data, document) {
    document.querySelectorAll('[data-src], [data-alt]').forEach(element => {
        const srcKey = element.getAttribute('data-src');
        const altKey = element.getAttribute('data-alt');
        const srcValue = getNestedValue(data, srcKey);
        const altValue = getNestedValue(data, altKey);
        if (srcValue) {
            element.setAttribute('src', srcValue);
        }
        if (altValue) {
            element.setAttribute('alt', altValue);
        }
    });
}

// Función para actualizar el contenido del DOM
function updateDOMWithJSONData(data, document) {
    document.querySelectorAll('[data-element]').forEach(element => {
        const key = element.getAttribute('data-element');
        const value = getNestedValue(data, key);
        if (value) {
            if (element.tagName === 'TITLE') {
                element.textContent = value;
            } else {
                const textNode = document.createTextNode(value + ' ');
                if (element.hasAttribute('data-after-insert')) {
                    // Insertar el nodo de texto después del contenido existente
                    element.appendChild(textNode);
                } else {
                    // Insertar el nodo de texto antes del primer nodo de texto existente
                    const firstTextNode = Array.from(element.childNodes).find(node => node.nodeType === Node.TEXT_NODE);
                    if (firstTextNode) {
                        element.insertBefore(textNode, firstTextNode);
                    } else {
                        element.insertBefore(textNode, element.firstChild);
                    }
                }
            }
        }
    });

    // Llamar a las funciones para actualizar los elementos <meta>, <link> y <img>
    updateMetaTags(data, document);
    updateAttributes(data, document);
}

// Función para manejar la respuesta del fetch
function handleFetchResponse(response) {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
}

// Función para manejar errores
function handleError(error) {
    console.error('Error al cargar el JSON:', error);
}

// Función principal para obtener datos del JSON y actualizar el DOM
function fetchDataAndUpdateDOM(url, document) {
    fetch(url)
        .then(handleFetchResponse)
        .then(data => updateDOMWithJSONData(data, document))
        .catch(handleError);
}

// Llamada a la función principal solo si estamos en el navegador
if (typeof document !== 'undefined') {
    fetchDataAndUpdateDOM('./data/content.json', document);
}