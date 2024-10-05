import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventSpaceFiltersComponent } from './event-space-filters.component';

describe('EventSpaceFiltersComponent', () => {
  let component: EventSpaceFiltersComponent;
  let fixture: ComponentFixture<EventSpaceFiltersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EventSpaceFiltersComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EventSpaceFiltersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
