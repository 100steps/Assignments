//
//  Person+CoreDataProperties.h
//  AddressBook
//
//  Created by 陈泽康 on 2016/10/30.
//  Copyright © 2016年 陈泽康. All rights reserved.
//
//  Choose "Create NSManagedObject Subclass…" from the Core Data editor menu
//  to delete and recreate this implementation file for your updated model.
//

#import "Person.h"

NS_ASSUME_NONNULL_BEGIN

@interface Person (CoreDataProperties)

@property (nullable, nonatomic, retain) NSString *name;
@property (nullable, nonatomic, retain) NSString *phone;
@property (nullable, nonatomic, retain) NSString *qq;

@end

NS_ASSUME_NONNULL_END
