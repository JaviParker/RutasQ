const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const { MercadoPagoConfig, Preference } = require('mercadopago');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const client = new MercadoPagoConfig({
    accessToken: 'TEST-4953738872013029-032418-9c1aefe6728a3b053f55ce0a5fb699fd-1583510283'
});

// Ruta para crear preferencia de pago
app.post('/create_preference', async (req, res) => {
    const { total } = req.body;
    const preference = new Preference(client);

    preference.create({
        body: {
            items: [{
                title: 'Total de compra',
                quantity: 1,
                currency_id: 'MXN',
                unit_price: parseFloat(total)
            }]
        }
    })
    .then(response => {
        // Asegurarse de acceder correctamente al ID
        if (response && response.id) {
            res.json({ id: response.id });
        } else {
            console.error('Unexpected response structure:', response);
            res.status(500).send('Unexpected response structure');
        }
    })
    .catch(error => {
        console.error('Error al crear la preferencia de pago:', error);
        res.status(500).send('Error al procesar el pago');
    });
});


const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});
