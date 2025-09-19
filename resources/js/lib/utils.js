const getAreaName = (areaId, areas) => {
    if (!areas || !Array.isArray(areas)) return "N/A";
    const area = areas.find((area) => area.id === areaId);
    return area ? area.name : "N/A";
};

const getUserName = (userId, users) => {
    if (!users || !Array.isArray(users)) return "N/A";
    const user = users.find((user) => user.id === userId);
    return user ? user.name : "N/A";
};

const getStatusName = (statusId, statuses) => {
    if (!statuses || !Array.isArray(statuses)) return "N/A";
    const status = statuses.find((status) => status.id === statusId);
    return status ? status.name : "N/A";
};

const getTechnicianName = (technicianId, technicians) => {
    if (!technicianId || !technicians || !Array.isArray(technicians))
        return "N/A";
    const technician = technicians.find((tech) => tech.id === technicianId);
    return technician ? technician.name : "N/A";
};

const getProjectName = (projectId, projects) => {
    if (!projects || !Array.isArray(projects)) return "N/A";
    const project = projects.find((project) => project.id === projectId);
    return project ? project.name : "N/A";
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
    getProjectName,
};
