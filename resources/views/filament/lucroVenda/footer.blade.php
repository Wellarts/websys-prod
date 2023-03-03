

<div class="grid grid-cols-6 border-2 text-lg">
  <div class="col-start-1 col-span-4 ">TOTAL</div>
  <div class="col-start-2 col-end-3  text-center"> R$ {{($this->getTableRecords()->sum('valor_total'))}}</div>
  <div class="col-start-3 col-end-4  text-center"> R$ {{($this->getTableRecords()->sum('valor_total')) - $this->getTableRecords()->sum('itens_venda_sum_valor_custo_atual')}}</div>
  
</div>


