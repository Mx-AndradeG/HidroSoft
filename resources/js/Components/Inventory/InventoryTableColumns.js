export default {
     columns: [
          {
            label: "Tipo de movimiento",
            field: "inventory_movement_type_name",
            width: "30%",
            sortable: true,
          },
          {
            label: "Fecha de creación",
            field: "formatted_created_at",
            width: "30%",
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
      