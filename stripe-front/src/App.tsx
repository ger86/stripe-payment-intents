import {ReactElement} from 'react';
import {AppBar, Box, Container, Grid, Toolbar, Typography} from '@material-ui/core';
import PaymentOrder from 'components/PaymentOrder';
import PaymentOrderList from 'components/PaymentOrderList';

function App(): ReactElement {
  return (
    <>
      <AppBar position="static">
        <Toolbar>
          <Typography variant="h6">Latte and Code</Typography>
        </Toolbar>
      </AppBar>
      <Container>
        <Box mt={8}>
          <Grid container spacing={4}>
            <Grid item lg={6}>
              <PaymentOrderList />
            </Grid>
            <Grid item lg={6}>
              <PaymentOrder />
            </Grid>
          </Grid>
        </Box>
      </Container>
    </>
  );
}

export default App;
