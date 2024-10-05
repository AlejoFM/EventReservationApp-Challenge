import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventSpaceFormComponent } from './event-space-form.component';

describe('EventSpaceFormComponent', () => {
  let component: EventSpaceFormComponent;
  let fixture: ComponentFixture<EventSpaceFormComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EventSpaceFormComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EventSpaceFormComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
