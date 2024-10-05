import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EventSpaceDetailComponent } from './event-space-detail.component';

describe('EventSpaceDetailComponent', () => {
  let component: EventSpaceDetailComponent;
  let fixture: ComponentFixture<EventSpaceDetailComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [EventSpaceDetailComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(EventSpaceDetailComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
