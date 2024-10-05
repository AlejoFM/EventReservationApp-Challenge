import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormControl, ReactiveFormsModule } from '@angular/forms';

@Component({
  selector: 'app-event-space-filters',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './event-space-filters.component.html',
  styleUrl: './event-space-filters.component.css'
})
export class EventSpaceFiltersComponent {
  capacity = new FormControl();
  date = new FormControl();

  applyFilters() {
    const filters = {
      capacity: this.capacity.value,
      date: this.date.value
    };
    // Emitir filtros a la lista de espacios
  }
}
