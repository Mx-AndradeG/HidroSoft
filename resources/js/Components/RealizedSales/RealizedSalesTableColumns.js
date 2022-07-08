export default {
     columns: [
          {
            label: "Vendio",
            field: "user_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Sucursal",
            field: "branch_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Cliente",
            field: "customer_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Metodo de pago",
            field: "payment_method_name",
            width: "15%",
            sortable: true,
          },
          {
            label: "Total de compra",
            field: "formatted_total_sale",
            width: "15%",
            sortable: true,
          },
          {
            label: "Fecha de registro",
            field: "Formatted_created_at",
            width: "3%",
            sortable: false,
          },
          {
            label: "Acciones",
            field: "actions",
            width: "3%",
            sortable: false,
          },
          
      ],
}
      