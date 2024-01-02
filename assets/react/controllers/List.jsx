import React from 'react';
import AddInvite from './AddInvite';
import CourseListe from './CourseListe';
import DeleteButton from './Delete';
import { Card } from '@mui/material';

export default function List ({ selectedList }){
  
  const data = selectedList ? selectedList.id : null;
  return (
    <Card sx={{ maxWidth: 400, padding: 5, backgroundColor : 'lightgray' }}>
      <h3>
        <div>
      {selectedList && (
        <div style={{display: 'flex', justifyContent: 'space-between'}}>
          <h2>{selectedList.name} </h2>
          <DeleteButton listId={selectedList.id}/>
          </div>
      )}
        </div>
        <div>
      {data && <AddInvite idList={data}/>}
        </div>
      </h3>
      {data && <CourseListe idList={data}/>}
      
    </Card>
  );
};
    