import React, { useState } from 'react';
import ClearIcon from '@mui/icons-material/Clear';
import { Button } from '@mui/material';

export default function DeleteCourse (props) {
  const handleDelete = async () => {
    try {
      const response = await fetch(`/api/course/${props.listId}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          // Ajoutez des en-têtes supplémentaires si nécessaire, tels que l'authentification
        },
      });

      if (response.status === 204) {
        // La suppression a réussi, appeler la fonction onDelete du parent pour mettre à jour l'état
        console.log("La suppression a réussi !")
          } else {
        // Gérer les erreurs de suppression ici
        console.error('Erreur lors de la suppression de la liste');
      }
    } catch (error) {
      console.error('Erreur réseau lors de la suppression de la liste', error);
    }
  };

  return (
    <Button onClick={handleDelete}>
      <ClearIcon/>
    </Button>
  );
};

