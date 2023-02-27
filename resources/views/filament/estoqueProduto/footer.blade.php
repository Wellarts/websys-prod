
 <table @class("border border-gray-300 w-full text-right table-auto font-bold bg-stone-400")>

    <tr>
        <td></td>
        <td class="filament-tables-cell text-2xl text-left">
              Resumo:
       </td>

            <td class="filament-tables-cell text-bg" alignment="right">

                   Valor Total Compra: R$ {{$this->getTableRecords()->sum('total_compra')}} <br>




            </td>
            <td></td>

    </tr>

</table>


