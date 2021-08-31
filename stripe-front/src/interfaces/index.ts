export enum Status {
  PENDING = 1,
  PROCESSING = 2,
  PAID = 3
}

export interface PaymentOrder {
  readonly id: string;
  readonly amount: {
    value: number;
    currency: string;
  };
  readonly description: string;
  readonly createdAt: string;
  readonly status: Status;
  readonly stripePaymentIntent: {
    paymentIntentId: string;
    clientSecret: string;
  };
}
