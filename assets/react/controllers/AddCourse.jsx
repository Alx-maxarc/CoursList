import { Button, TextField } from '@mui/material';
import React, { useState } from 'react';
import LibraryAddIcon from '@mui/icons-material/LibraryAdd';

export default function AddCourse ({ listId }) {
  const [courseName, setCourseName] = useState('');

  const handleAddCourse = async () => {
    try {
      const response = await fetch(`/liste/${listId}/addCourse`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ name: courseName }),
      });

      if (!response.ok) {
        throw new Error(`Erreur lors de l'ajout de la course: ${response.status}`);
      }


      console.log('Course ajoutée avec succès!');
    } catch (error) {
      console.error(error.message);
    }
  };

  return (
    <div>
      <h2>Ajouter une nouvelle course</h2>
      <TextField 
      type='text'
      label="Lait ?" 
      variant="filled" 
      value={courseName}
      onChange={(e) => setCourseName(e.target.value)}
      />
      <Button onClick={handleAddCourse}>
        <LibraryAddIcon/>
        </Button>
    </div>
  );
};

