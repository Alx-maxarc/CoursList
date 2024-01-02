import React, { useState, useEffect } from 'react';
import DeleteButton from './Delete';
import BoutonList from './BoutonList';
import List from './List';
import { Button } from '@mui/material';
import AddListForm from './AddList';

export default function CardList() {
  const [listes, setListes] = useState([]);
  const [selectedList, setSelectedList] = useState(null);

  useEffect(() => {
    // Effectuer l'appel API lors du montage du composant
    fetch('/api/list') // Remplacez par l'URL de votre API
      .then(response => response.json())
      .then(data => setListes(data))
      .catch(error => console.error("Erreur lors de la récupération des listes", error));
  }, []); // Le tableau vide signifie que cet effet n'a besoin de s'exécuter qu'une seule fois lors du montage


  const handleBoutonListClick = (listId, listName) => {
    setSelectedList({ id: listId, name: listName });
  };

  return (
    <div style={{ display: 'flex', flexDirection: 'column'}}>
    <div>
      <div style={{display: 'flex', justifyContent: 'space-between'}}>
      <h2>Mes listes</h2>
      <AddListForm/>
      </div>
      <div style={{display: 'flex', flexDirection: 'row', padding: '10px'}}>
      {listes.map((liste, index) => (
      
      <BoutonList key={index} liste={liste} onBoutonClick={handleBoutonListClick}/>
      
  ))}</div>
    </div>
    <div>
      <List selectedList={selectedList} />
    </div>
    </div>
  );
};