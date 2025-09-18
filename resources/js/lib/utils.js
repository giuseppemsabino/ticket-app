const getAreaName = (areaId, areas) => {
    const area = areas.find((area) => area.id === areaId);
    return area ? area.name : "N/A";
};

const getUserName = (userId, users) => {
    const user = users.find((user) => user.id === userId);
    return user ? user.name : "N/A";
};

const getStatusName = (statusId, statuses) => {
    const status = statuses.find((status) => status.id === statusId);
    return status ? status.name : "N/A";
};

const getTechnicianName = (technicianId, technicians) => {
    const technician = technicians.find((tech) => tech.id === technicianId);
    return technician ? technician.name : "N/A";
};

const deleteTicket = (ticketId, router, route) => {
    if (confirm("Sei sicuro di voler eliminare questo ticket?")) {
        router.delete(route("tickets.destroy", ticketId));
    }
};

export {
    getAreaName,
    getUserName,
    getStatusName,
    getTechnicianName,
    deleteTicket,
};
