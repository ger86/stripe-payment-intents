import {ChangeEvent, ReactElement, SyntheticEvent, useState} from 'react';
import {Box, TextField, Button} from '@material-ui/core';
import {Elements} from '@stripe/react-stripe-js';
import {loadStripe} from '@stripe/stripe-js';
import {STRIPE_KEY} from 'const';
import {PaymentOrder as PaymentOrderInterface} from 'interfaces';
import PaymentOrderPay from './components/PaymentOrderPay';

const stripePromise = loadStripe(STRIPE_KEY);

export default function PaymentOrder(): ReactElement {
  const [amount, setAmount] = useState('');
  const [description, setDescription] = useState('');
  const [email, setEmail] = useState('');
  const [isCreatingPaymentOrder, setIsCreatingPaymentOrder] = useState(false);
  const [paymentOrder, setPaymentOrder] = useState<PaymentOrderInterface | null>(null);

  function handleChangeAmount(event: ChangeEvent<any>) {
    setAmount(event.target.value);
  }

  function handleChangeDescription(event: ChangeEvent<any>) {
    setDescription(event.target.value);
  }

  function handleChangeEmail(event: ChangeEvent<any>) {
    setEmail(event.target.value);
  }

  function handleSubmit(event: SyntheticEvent) {
    async function fetchData() {
      setIsCreatingPaymentOrder(true);
      const response = await fetch('http://stripe.latteandcode.test/api/payment-orders', {
        method: 'POST',
        body: JSON.stringify({
          amount,
          description,
          email
        })
      });
      const json = await response.json();
      setPaymentOrder(json);
      setIsCreatingPaymentOrder(false);
    }
    event.preventDefault();
    fetchData();
  }

  return (
    <Elements stripe={stripePromise}>
      <div>
        {paymentOrder === null && (
          <form onSubmit={handleSubmit}>
            <Box mb={2}>
              <TextField
                required
                fullWidth
                id="description"
                name="description"
                label="Descripción"
                value={description}
                onChange={handleChangeDescription}
              />
            </Box>
            <Box mb={2}>
              <TextField
                required
                fullWidth
                id="email"
                name="email"
                label="Email"
                value={email}
                onChange={handleChangeEmail}
              />
            </Box>
            <Box mb={2}>
              <TextField
                required
                fullWidth
                id="amount"
                name="amount"
                label="Cantidad"
                value={amount}
                onChange={handleChangeAmount}
              />
            </Box>
            <Box>
              <Button
                fullWidth
                variant="contained"
                color="primary"
                disabled={isCreatingPaymentOrder}
                type="submit"
              >
                Pagar {amount} €
              </Button>
            </Box>
          </form>
        )}
        {paymentOrder && <PaymentOrderPay paymentOrder={paymentOrder} />}
      </div>
    </Elements>
  );
}
