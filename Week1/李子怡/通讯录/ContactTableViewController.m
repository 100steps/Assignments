//
//  ContactTableViewController.m
//  通讯录
//
//  Created by apple on 2016/10/6.
//  Copyright © 2016年 modouhe. All rights reserved.
//

#import "ContactTableViewController.h"
#import "AddViewController.h"
#import "EditViewController.h"
#import <CoreData/CoreData.h>
#import "People+CoreDataProperties.h"



//#define ContactFilePath [ [NSSearchPathForDirectoriesInDomains (NSDocumentDirectory, NSUserDomainMask, YES) lastObject] stringByAppendingPathComponent:@"contacts.data"]

@interface ContactTableViewController ()<NSFetchedResultsControllerDelegate>



@property (nonatomic, strong) NSManagedObjectContext * managedObjectContext;//上下文对象
@property (nonatomic, strong) NSFetchedResultsController * fetchResultsController;
@end

@implementation ContactTableViewController


#pragma mark - 获取本应用的上下文对象
-(NSManagedObjectContext *)applicationManagedObjectContext{
    UIApplication * application = [UIApplication sharedApplication];
    id delegate = application. delegate;
    //返回应用的上下文对象
    return [delegate managedObjectContext];
}


- (void)viewDidLoad {
    [super viewDidLoad];
    
    //去除多余的线
    [self clearExtraLine:self. tableView];
    
    //获取该应用的上下文对象
   self. managedObjectContext = [self applicationManagedObjectContext];
    

    
    //创建请求
    NSFetchRequest * request = [[NSFetchRequest alloc]initWithEntityName:NSStringFromClass([People class])];
    
    //定义分组与排序规则
    NSSortDescriptor * sortDescriptor = [NSSortDescriptor sortDescriptorWithKey:@"firstN" ascending:YES];
   
    //加载排序
     [request setSortDescriptors:@[sortDescriptor]];
    
    //把请求结果转换成适合tableView显示的数据
    self. fetchResultsController = [[NSFetchedResultsController alloc]initWithFetchRequest:request managedObjectContext:self. managedObjectContext sectionNameKeyPath:@"firstN" cacheName:nil];
    
    //执行fetchResultsController
    NSError * error;
    if (![self.fetchResultsController performFetch:&error])
    {
        NSLog(@"%@",[error localizedDescription]);
    }

    
    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
    
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}



#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView {
   //fetchedResultsController中的sections方法可以以数组形式返回所有的section
    NSArray * sections = [self. fetchResultsController sections];
    return sections.count;

}


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section {
    //获取fetchResultsController的所有的组
    NSArray * sections = [self. fetchResultsController sections];
    
    //获取每组的信息
    id <NSFetchedResultsSectionInfo> sectionInfo = sections[section];
    
    return [sectionInfo numberOfObjects] ;
}


- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath {
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"mycell" forIndexPath:indexPath];
    People * people = [self. fetchResultsController objectAtIndexPath: indexPath];
  

    cell. textLabel. text = people. name;
    cell. detailTextLabel. text = people. phone;
    cell. accessoryType = UITableViewCellAccessoryDisclosureIndicator;
    
    return cell;
}


#pragma mark - 实现 NSFetchResultsControllerDelegate 的方法
//当控制器监控的数据发生改变时，如对象被删除，有插入，更新等，监视器会在数据发生改变前意识到这个情况，此时就会调用这个函数。往往我们用列表的形式表现数据，此时意味着屏幕上的数据即将过时，因为数据马上要改变了，这是这个协议方法的工作就是通知列表数据马上要更新的消息，往往代码是这样实现的。
- (void)controllerWillChangeContent:(NSFetchedResultsController *)controller {
    [self.tableView beginUpdates];
}

//分区改变状况
- (void)controller:(NSFetchedResultsController *)controller didChangeSection:(id <NSFetchedResultsSectionInfo>)sectionInfo
           atIndex:(NSUInteger)sectionIndex forChangeType:(NSFetchedResultsChangeType)type {
    
    switch(type) {
        case NSFetchedResultsChangeInsert:
            [self.tableView insertSections:[NSIndexSet indexSetWithIndex:sectionIndex]
                          withRowAnimation:UITableViewRowAnimationFade];
            break;
            
        case NSFetchedResultsChangeDelete:
            [self.tableView deleteSections:[NSIndexSet indexSetWithIndex:sectionIndex]
                          withRowAnimation:UITableViewRowAnimationFade];
            break;
    }
}

//数据改变状况
- (void)controller:(NSFetchedResultsController *)controller didChangeObject:(id)anObject
       atIndexPath:(NSIndexPath *)indexPath forChangeType:(NSFetchedResultsChangeType)type
      newIndexPath:(NSIndexPath *)newIndexPath
{
    
    UITableView *tableView = self.tableView;
    
    switch(type) {
            //如果是组中加入新的对象
        case NSFetchedResultsChangeInsert:
           //让tableView在newIndexPath位置插入一个cell
            [tableView insertRowsAtIndexPaths:[NSArray arrayWithObject:newIndexPath]
                             withRowAnimation:UITableViewRowAnimationFade];
            break;
            //如果是组中删除了对象
        case NSFetchedResultsChangeDelete:
            [tableView deleteRowsAtIndexPaths:[NSArray arrayWithObject:indexPath]
                             withRowAnimation:UITableViewRowAnimationFade];
            break;
            //如果是组中的对象发生了变化
        case NSFetchedResultsChangeUpdate:
             //让tableView刷新indexPath位置上的cell
            [tableView reloadRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
            break;
            //如果是组中的对象位置发生了变化
        case NSFetchedResultsChangeMove:
            [tableView deleteRowsAtIndexPaths:[NSArray arrayWithObject:indexPath]
                             withRowAnimation:UITableViewRowAnimationFade];
            [tableView insertRowsAtIndexPaths:[NSArray arrayWithObject:newIndexPath]
                             withRowAnimation:UITableViewRowAnimationFade];
            break;
    }
}  

//    当fetchedResultsController完成对数据的改变时，监视器会调用这个协议方法。在上面提到的情况，这个方法要通知列表数据已经完成，可以更新显示的数据这个消息，因此通常的实现是这样的。
- (void)controllerDidChangeContent:(NSFetchedResultsController *)controller {
    [self.tableView endUpdates];
}


#pragma mark -  去掉多余的线
-(void)clearExtraLine : (UITableView *)tableView{
    UIView *view = [[UIView alloc] init];
    view.backgroundColor = [UIColor clearColor];
    [self.tableView setTableFooterView:view];
}



// Override to support conditional editing of the table view.
- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath {
    // Return NO if you do not want the specified item to be editable.
    return YES;
}


/*
// Override to support editing the table view.
- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath {
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        // Delete the row from the data source
        [tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    } else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
    }   
}
*/

/*
// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath {
}
*/

/*
// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath {
    // Return NO if you do not want the item to be re-orderable.
    return YES;
}
*/


#pragma mark - Navigation

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {

    if ([sender isKindOfClass:[EditViewController class]]){
        //做一个类型转换
        UITableViewCell *cell = (UITableViewCell *)sender;
        
        //通过tableView获取cell对应的索引 然后通过索引获取实体对象
        NSIndexPath *indexPath = [self. tableView indexPathForCell:cell];
        
        // 用frc通过indexpath来获取person
        People *people = [self. fetchResultsController objectAtIndexPath:indexPath];
        
        //通过segue来获取我们目的视图控制器
        UIViewController *nextView = [segue destinationViewController];
        
        //通过kvc把参数传入目的控制器
        [nextView setValue:people forKey:@"people"];
    }
}



-(void)tableView: (UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle
forRowAtIndexPath: (NSIndexPath *)indexPath{
    
    if (editingStyle == UITableViewCellEditingStyleDelete) {
            
    //通过indexPath获取要删除的实体
    People * people = [self.fetchResultsController objectAtIndexPath:indexPath];
            
    //从上下文中删除该实体
    [self.managedObjectContext deleteObject:people];
            
    //上下文保存
    NSError * error;
      if (![self.managedObjectContext save:&error]){
                NSLog(@"%@",[error localizedDescription]);
            }
        
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }     
    }

-(NSString *)tableView:(UITableView *)tableView titleForDeleteConfirmationButtonForRowAtIndexPath:(NSIndexPath *)indexPath{
    
    return @"删除";
}

@end
