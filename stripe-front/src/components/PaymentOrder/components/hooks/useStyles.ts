import {makeStyles} from '@material-ui/core/styles';

const useStyles = makeStyles(theme => ({
  cardBox: {
    width: '450px',
    padding: theme.spacing(2),
    border: `1px solid ${theme.palette.primary.light}`,
    backgroundColor: theme.palette.grey[100]
  }
}));

export default useStyles;
