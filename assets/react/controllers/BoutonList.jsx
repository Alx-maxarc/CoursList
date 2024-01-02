// BoutonList.jsx
import { Button } from '@mui/material';
import React from 'react';

export default function BoutonList( props ) {
  const handleBoutonClick = () => {
    props.onBoutonClick(props.liste.id, props.liste.name);
  };

  return (
    <Button variant="outlined" size="medium" style={{margin: '10px'}}
    onClick={handleBoutonClick}>
      {props.liste.name}
    </Button>
  );
};

