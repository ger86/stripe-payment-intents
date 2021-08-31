import {ReactElement} from 'react';
import {Button, Box, CircularProgress} from '@material-ui/core';
import {CardElement} from '@stripe/react-stripe-js';
import {PaymentOrder} from 'interfaces';
import useStripePaymentRequest from './hooks/useStripePaymentRequest';
import useStyles from './hooks/useStyles';

type Props = {
  paymentOrder: PaymentOrder;
};

const cardStyle = {
  style: {
    base: {
      color: '#32325d',
      fontFamily: 'Arial, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '16px',
      '::placeholder': {
        color: '#32325d'
      }
    },
    invalid: {
      color: '#fa755a',
      iconColor: '#fa755a'
    }
  }
};

export default function PaymentOrderPay({paymentOrder}: Props): ReactElement {
  const classes = useStyles();
  const [requestState, onChangeInCardElement, onSubmitPayment] = useStripePaymentRequest(
    paymentOrder
  );

  const amount = `${paymentOrder.amount.value} ${paymentOrder.amount.currency}`;

  return (
    <div>
      <div className={classes.cardBox}>
        <form id="payment-form" onSubmit={onSubmitPayment}>
          <Box mb={2}>
            <CardElement id="card-element" options={cardStyle} onChange={onChangeInCardElement} />
          </Box>
          <Box display="flex" alignItems="center">
            <Button
              disabled={
                requestState.isProcessing || requestState.isDisabled || requestState.isSucceeded
              }
              id="submit"
              color="primary"
              variant="contained"
              type="submit"
            >
              {requestState.isProcessing ? `Pagando ${amount}` : `Pagar ${amount}`}
            </Button>
            {requestState.isProcessing && <CircularProgress />}
          </Box>
          {requestState.error && (
            <Box mt={2}>
              <div>Se ha producido un error realizando el pago</div>
            </Box>
          )}
          {requestState.isSucceeded && (
            <Box mb={2} mt={2}>
              <div>Tu pago se está procesando</div>
            </Box>
          )}
        </form>
      </div>
    </div>
  );
}
