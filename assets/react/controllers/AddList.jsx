import { Button, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, TextField } from '@mui/material';
import React, { useState } from 'react';
import PostAddIcon from '@mui/icons-material/PostAdd';

export default function AddListForm () {
  const [listName, setListName] = useState('');

  const handleInputChange = (event) => {
    setListName(event.target.value);
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    // Créez un objet avec les données du formulaire
    const formData = {
      name: listName,
      // Ajoutez d'autres propriétés selon votre modèle
    };

    try {
      // Effectuez une requête POST vers l'API Symfony avec les données du formulaire
      const response = await fetch('/addListCourse', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (response.ok) {
        // La liste a été créée avec succès
        console.log('Liste de course créée avec succès');
      } else {
        // Gestion des erreurs
        console.error('Erreur lors de la création de la liste de course');
      }
    } catch (error) {
      console.error('Erreur lors de la requête API', error);
    }
  };
  const [open, setOpen] = React.useState(false);

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };


  return (
    <div>
      <Button variant="outlined" onClick={handleClickOpen}>
        <PostAddIcon/>
      </Button>
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>Ajouter une liste</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Pour les courses, les taches ménagères, ou même pour un pense bête, les listes sont faite pour vous.
          </DialogContentText>
          
          <form onSubmit={handleSubmit}>
          <TextField
            autoFocus
            margin="dense"
            id="list"
            label="Nom de votre nouvelle liste"
            type= 'text'
            fullWidth
            variant="standard"
            value={listName}
             onChange={handleInputChange}
            required
          />
        
        <DialogActions>
          <Button onClick={handleClose}>Annuler</Button>
          <Button type="submit" onClick={handleClose}>Ajouter</Button>
        </DialogActions>
        </form>
        </DialogContent>
      </Dialog>
      </div>
      
  );
};