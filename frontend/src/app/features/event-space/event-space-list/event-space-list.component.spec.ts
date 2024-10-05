import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventSpaceListComponent } from './event-space-list.component';

describe('EventSpaceListComponent', () => {
  let component: EventSpaceListComponent;
  let fixture: ComponentFixture<EventSpaceListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EventSpaceListComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EventSpaceListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
