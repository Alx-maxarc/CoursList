import React, { useState, useEffect } from 'react';
import AddCourse from './AddCourse';
import DeleteCourse from './DeleteCourse';

export default function CourseListe(props) {
  const [listes, setListes] = useState([]);

  useEffect(() => {
    // Effectuer l'appel API lors du montage du composant
    fetch(`/api/course/${props.idList}`) // Remplacez par l'URL de votre API
      .then(response => response.json())
      .then(data => setListes(data))
      .catch(error => console.error("Erreur lors de la récupération des listes", error));
  }); // Le tableau vide signifie que cet effet n'a besoin de s'exécuter qu'une seule fois lors du montage



  return (
    <div>
      <AddCourse listId={props.idList}/>
      {listes.map((liste, index) => (
    <div style={{display: 'flex', justifyContent: 'space-between'}}>
    <p key={index}>
     {liste.name}
     </p>
     <DeleteCourse listId={liste.id}/>
     </div>
    
  ))}
    </div>
  
  );
};