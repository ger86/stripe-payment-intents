import {useCallback, useState} from 'react';
import {CardElement, useStripe, useElements} from '@stripe/react-stripe-js';
import {PaymentOrder, Status} from 'interfaces';

export type RequestState = {
  isSucceeded: boolean;
  isProcessing: boolean;
  isDisabled: boolean;
  error: string | null;
};

export type OnChangeInCardElement = (event: any) => void;
export type OnSubmitPayment = (event: any) => void;

export default function useStripePaymentRequest(
  paymentOrder: PaymentOrder
): [RequestState, OnChangeInCardElement, OnSubmitPayment] {
  const [requestState, setRequestState] = useState<RequestState>({
    isSucceeded: false,
    error: null,
    isProcessing: false,
    isDisabled: true
  });
  const stripe = useStripe();
  const elements = useElements();

  const onChangeInCardElement = useCallback(function(event) {
    setRequestState({
      isSucceeded: false,
      error: event.error ? event.error.message : '',
      isProcessing: false,
      isDisabled: event.empty
    });
  }, []);

  const onSubmitPayment = useCallback(
    async function(event) {
      event.preventDefault();
      try {
        if (!stripe || !elements) {
          return;
        }
        const card = elements.getElement(CardElement);
        if (!card) {
          return;
        }
        setRequestState({
          isSucceeded: false,
          error: null,
          isProcessing: true,
          isDisabled: false
        });
        const payload = await stripe.confirmCardPayment(
          paymentOrder.stripePaymentIntent.clientSecret,
          {
            payment_method: {
              card
            }
          }
        );
        if (payload.error) {
          setRequestState({
            isSucceeded: false,
            error: payload.error.message ?? '',
            isProcessing: false,
            isDisabled: false
          });
          return;
        }
        const response = await fetch(
          `http://stripe.latteandcode.test/api/payment-orders/${paymentOrder.id}`,
          {
            method: 'PATCH',
            body: JSON.stringify({
              status: Status.PROCESSING
            })
          }
        );
        if (response.ok) {
          setRequestState({
            isSucceeded: true,
            error: null,
            isProcessing: false,
            isDisabled: false
          });
          return;
        }
        setRequestState({
          isSucceeded: false,
          error: 'Error marcando como procesada',
          isProcessing: false,
          isDisabled: false
        });
      } catch (error) {
        setRequestState({
          isSucceeded: false,
          error: error.message ?? '',
          isProcessing: false,
          isDisabled: false
        });
      }
    },
    [elements, paymentOrder.id, paymentOrder.stripePaymentIntent.clientSecret, stripe]
  );

  return [requestState, onChangeInCardElement, onSubmitPayment];
}
