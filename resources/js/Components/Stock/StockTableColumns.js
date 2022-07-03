export default {
     columns: [
          {
            label: "ID",
            field: "id",
            width: "3%",
            sortable: true,
            isKey: true,
          },
          {
            label: "Tipo de movimiento",
            field: "inventory_movement_type_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Fecha de creación",
            field: "formatted_created_at",
            width: "15%",
            sortable: true,
          },
          {
            label: "Acciones",
            field: "actions",
            width: "3%",
            sortable: false,
          },
          
      ],
}
      