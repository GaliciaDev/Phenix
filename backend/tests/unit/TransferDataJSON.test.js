const { JSDOM } = require('jsdom');
const { getNestedValue, updateDOMWithJSONData } = require('../../../frontend/assets/js/middleware/TransferDataJSON');

// Pruebas para la función getNestedValue
describe('getNestedValue', () => {
    const data = {
        textForm: {
            branchText: "Sensi Home",
            branchTextEnfasis: "Ya construimos un freamwork JS con menos codigo que react"
        }
    };

    test('debería devolver el valor correcto para una clave anidada', () => {
        expect(getNestedValue(data, 'textForm.branchText')).toBe('Sensi Home');
        expect(getNestedValue(data, 'textForm.branchTextEnfasis')).toBe('Ya construimos un freamwork JS con menos codigo que react');
    });

    test('debería devolver null para una clave inexistente', () => {
        expect(getNestedValue(data, 'textForm.nonExistentKey')).toBeNull();
    });
});

// Pruebas para la lógica de inserción de texto en el DOM
describe('updateDOMWithJSONData', () => {
    let dom;
    let document;

    beforeEach(() => {
        dom = new JSDOM(`
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Conversion mediante API</title>
            </head>
            <body>
                <p data-element="textForm.branchText"><strong data-element="textForm.branchTextEnfasis">Generacion de contenido</strong></p>
            </body>
            </html>
        `);
        document = dom.window.document;
        global.Node = dom.window.Node; // Definir Node globalmente
    });

    const data = {
        textForm: {
            branchText: "Sensi Home",
            branchTextEnfasis: "Ya construimos un freamwork JS con menos codigo que react"
        }
    };

    test('debería insertar el texto del JSON al principio del contenido del elemento', () => {
        updateDOMWithJSONData(data, document);

        const pElement = document.querySelector('p[data-element="textForm.branchText"]');
        expect(pElement.textContent).toBe('Sensi Home Generacion de contenido');
    });
});