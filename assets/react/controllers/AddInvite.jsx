import React, { useState } from 'react';
import GroupAddIcon from '@mui/icons-material/GroupAdd';
import { Button, Dialog, DialogActions, DialogContent, DialogContentText, DialogTitle, TextField } from '@mui/material';

export default function AddInvite ({idList}) {
  const [InviteName, setInviteName] = useState('');

  const handleInputChange = (event) => {
    setInviteName(event.target.value);
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    // Créez un objet avec les données du formulaire
    const formData = {
      email: InviteName,
      listId: idList
    // Ajoutez d'autres propriétés selon votre modèle
    };

    try {
      // Effectuez une requête POST vers l'API Symfony avec les données du formulaire
      const response = await fetch('/inviteUserToList', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData),
      });

      if (response.ok) {
        // La liste a été créée avec succès
        console.log('Invité ajouté avec succès');
      } else {
        // Gestion des erreurs
        console.error("Erreur lors de l'ajout d'invité à la liste");
      }
    } catch (error) {
      console.error('Erreur lors de la requête API', error);
    }
  };

  const [open, setOpen] = useState(false);

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };


  return (
    <div>
      <Button variant="outlined" onClick={handleClickOpen}>
      <GroupAddIcon/>
      </Button>
      <Dialog open={open} onClose={handleClose}>
      <DialogTitle>Invitez un ami !</DialogTitle>
      <DialogContent>
          <DialogContentText>
            A deux ou en groupe, partagez vos listes ! Ajouter un ami grâce à son adresse email.
          </DialogContentText>
          
      <form onSubmit={handleSubmit}>
      <TextField 
            
            autoFocus
            margin="dense"
            id="name"
            label="Email de votre invité"
            type="email"
            fullWidth
            variant="standard"
            value={InviteName} 
            onChange={handleInputChange} 
            required
          />
      <DialogActions>
          <Button onClick={handleClose}>Annuler</Button>
          <Button type="submit" onClick={handleClose}>Inviter</Button>
        </DialogActions>
        </form>
        </DialogContent >
      </Dialog>
    </div>
  );
};