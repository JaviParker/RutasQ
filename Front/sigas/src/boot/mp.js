const mercadopago = require('mercadopago');
mercadopago.configure({
  access_token: 'TEST-4953738872013029-032418-9c1aefe6728a3b053f55ce0a5fb699fd-1583510283'
});

app.post('/create_preference', async (req, res) => {
  let preference = {
    items: [
      {
        title: 'Total de compra',
        quantity: 1,
        currency_id: 'MXN',
        unit_price: parseFloat(req.body.total)
      }
    ]
  };

  try {
    const response = await mercadopago.preferences.create(preference);
    res.send({ id: response.body.id });
  } catch (error) {
    res.status(500).send(error);
  }
});
