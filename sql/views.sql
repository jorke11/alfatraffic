drop view vpurchases
create view vpurchases as 
select p.id,p.name,p.last_name,p.telephone, s.description as state,p.email,p.status_id as status
from purchases p
JOIN states s ON s.id=p.state_id
