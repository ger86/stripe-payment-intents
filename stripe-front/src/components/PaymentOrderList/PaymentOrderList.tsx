import {ReactElement, useEffect, useState} from 'react';
import {
  CardActions,
  Chip,
  CircularProgress,
  CardContent,
  Grid,
  Typography,
  Card,
  Box,
  Button
} from '@material-ui/core';
import {PaymentOrder, Status} from 'interfaces';

export default function PaymentOrderList(): ReactElement {
  const [isLoading, setIsLoading] = useState(false);
  const [paymentOrders, setPaymentOrders] = useState<PaymentOrder[] | null>(null);

  async function fetchData() {
    setIsLoading(true);
    const response = await fetch('http://stripe.latteandcode.test/api/payment-orders');
    const json = await response.json();
    setPaymentOrders(json);
    setIsLoading(false);
  }

  useEffect(function() {
    fetchData();
  }, []);

  function refresh() {
    fetchData();
  }

  return (
    <div>
      <Grid container spacing={4}>
        {isLoading && <CircularProgress />}
        {paymentOrders &&
          paymentOrders.map(paymentOrder => (
            <Grid item xs={6} key={paymentOrder.id}>
              <Card>
                <CardContent>
                  <Typography variant="h3" color="textPrimary" gutterBottom>
                    {`${paymentOrder.amount.value} ${paymentOrder.amount.currency}`}
                  </Typography>
                  <Typography variant="h4" color="textSecondary" gutterBottom>
                    {paymentOrder.createdAt}
                  </Typography>
                  <Typography color="textSecondary">{paymentOrder.description}</Typography>
                </CardContent>
                <CardActions>
                  {paymentOrder.status === Status.PENDING && <Chip label="Pendiente" />}
                  {paymentOrder.status === Status.PROCESSING && (
                    <Chip label="Procesando" color="secondary" />
                  )}
                  {paymentOrder.status === Status.PAID && <Chip label="Pagado" color="primary" />}
                </CardActions>
              </Card>
            </Grid>
          ))}
        {paymentOrders && paymentOrders.length === 0 && (
          <Typography>Todavía no hay órdenes de pago</Typography>
        )}
      </Grid>
      <Box mt={4}>
        <Button variant="outlined" color="secondary" onClick={refresh}>
          Refrescar
        </Button>
      </Box>
    </div>
  );
}
